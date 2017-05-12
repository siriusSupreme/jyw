<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:59
 */

namespace utils;


class Auth {

  //权限实例
  private static $authInstance=null;
  //权限配置
  private $config=[
    'auth_on'=>true,//开启权限认证
    'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
    'auth_group'        => 'admin_group', // 用户组数据表名
    'auth_user' => 'admin', // 用户信息表
    'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
    'auth_rule'         => 'auth_rule', // 权限规则表
  ];

  /**
   * Auth constructor.
   *
   * @param array $config
   */
  private function __construct($config) {
    /*合并配置参数*/
    if (!empty( $config) && is_array( $config)){
      $this->config=array_merge( $this->config,$config);
    }
  }

  /**
   * 获取权限实例
   * @param array $config 配置参数
   * @param bool $force 是否强制重新实例化
   *
   * @return null|static
   */
  public static function getInstance($config,$force=false){
    if (is_null( self::$authInstance) || $force===true){
      self::$authInstance=new static( $config);
    }
    return self::$authInstance;
  }

  /**
   * 动态设置配置项
   * @param string|array $name
   * @param null|string|integer|bool $value
   *
   * @return $this
   */
  public function setConfig($name,$value=null){
    if (is_array( $name)){
      $this->config=array_merge( $this->config,$name);
    }elseif(is_string( $name)&&$value!==null){
      $this->config[$name]=$value;
    }
    return $this;
  }

  /**
   * 规则检测
   * @param string|array $names 待认证规则
   * @param integer $userId 待认证用户ID
   * @param string $ruleType  待认证规则类型 url or normal
   * @param string $relation  认证模式 and or or
   * @param string $returnType  验证通过时返回类型 rule or id
   *
   * @return bool|array|integer
   */
  public function check($names,$userId,$ruleType='url',$relation='and',$returnType='rule'){
    if ( !$this->config[ 'auth_on' ] ) {
      return true;
    }
    // 获取用户需要验证的所有有效规则列表
    $rulelist = $this->getRuleList( $uid );
    if ( in_array( '*', $rulelist ) ) {
      return true;
    }

    if ( is_string( $name ) ) {
      $name = strtolower( $name );
      if ( strpos( $name, ',' ) !== false ) {
        $name = explode( ',', $name );
      } else {
        $name = [ $name ];
      }
    }
    $list = []; //保存验证通过的规则名
    if ( 'url' == $mode ) {
      $REQUEST = unserialize( strtolower( serialize( $this->request->param() ) ) );
    }
    foreach ( $rulelist as $rule ) {
      $query = preg_replace( '/^.+\?/U', '', $rule );
      if ( 'url' == $mode && $query != $rule ) {
        parse_str( $query, $param ); //解析规则中的param
        $intersect = array_intersect_assoc( $REQUEST, $param );
        $rule = preg_replace( '/\?.*$/U', '', $rule );
        if ( in_array( $rule, $name ) && $intersect == $param ) {
          //如果节点相符且url参数满足
          $list[] = $rule;
        }
      } else {
        if ( in_array( $rule, $name ) ) {
          $list[] = $rule;
        }
      }
    }
    if ( 'or' == $relation && !empty( $list ) ) {
      return true;
    }
    $diff = array_diff( $name, $list );
    if ( 'and' == $relation && empty( $diff ) ) {
      return true;
    }

    return false;
  }

  public function checkOne(){

  }

  public function checkAll(){

  }

  public function checkAny(){

  }

  public function getUserInfoByUserId($userId){

  }

  public function getGroupsByUserId( $userId){

  }

  public function getRulesByGroups($groupIds){
    static $_authList = array(); //保存用户验证通过的权限列表
    $mode = $mode ? : 'url';
    $t = implode( ',', (array)$type );
    if ( isset( $_authList[ $uid . '_' . $t . '_' . $mode ] ) ) {
      return $_authList[ $uid . '_' . $t . '_' . $mode ];
    }
    //登录验证时,返回保存在session的列表
    if ( $this->_config[ 'auth_type' ] == 2 && isset( $_SESSION[ '_AUTH_LIST_' . $uid . '_' . $t . '_' . $mode ] ) ) {
      return $_SESSION[ '_AUTH_LIST_' . $uid . '_' . $t . '_' . $mode ];
    }
    //读取用户所属用户组
    $groups = $this->getGroups( $uid );
    $ids = array();//保存用户所属用户组设置的所有权限规则id
    foreach ( $groups as $g ) {
      $ids = array_merge( $ids, explode( ',', trim( $g[ 'rules' ], ',' ) ) );
    }
    $ids = array_unique( $ids );
    if ( empty( $ids ) ) {
      $_authList[ $uid . $t ] = array();

      return array();
    }
    //rules的ids
    $map = array(
      'id'       => array( 'in', $ids ),
      'type'     => $type,
      'notcheck' => 0,
    );
    //读取用户组所有权限规则
    $rules = db()
      ->name( $this->_config[ 'auth_rule' ] )
      ->where( $map )
      ->whereOr( 'notcheck', 1 )
      ->field( 'id,condition,name,notcheck' )
      ->select();
    //循环规则，判断结果。
    $authList = array();
    foreach ( $rules as $rule ) {
      if ( $rule[ 'notcheck' ] || empty( $rule[ 'condition' ] ) ) {
        $authList[] = ( $mode == 'url' ) ? strtolower( $rule[ 'name' ] ) : $rule[ 'id' ];
      } else {
        $user = $this->getUserInfo( $uid );//获取用户信息,一维数组
        $command = preg_replace( '/\{(\w*?)\}/', '$user[\'\\1\']', $rule[ 'condition' ] );
        @( eval( '$condition=(' . $command . ');' ) );
        if ( $condition ) {
          $authList[] = ( $mode == 'url' ) ? strtolower( $rule[ 'name' ] ) : $rule[ 'id' ];
        }
      }
    }

    $_authList[ $uid . '_' . $t . '_' . $mode ] = $authList;
    if ( $this->_config[ 'auth_type' ] == 2 ) {
      //规则列表结果保存到session
      session( '_AUTH_LIST_' . $uid . '_' . $t . '_' . $mode, $authList );
    }

    return array_unique( $authList );
  }
}
