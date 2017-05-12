<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:59
 */

namespace utils;


use think\Db;
use think\Loader;
use think\Session;

class Auth {

  //权限实例
  private static $authInstance=null;
  //权限配置
  private $config=[
    'auth_on'=>true,//开启权限认证
    'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证
    'auth_endpoint' => 0, // 认证端，0为后台；1为前台；2为API
    'auth_param_delimiter'=>',',//认证参数分隔符
    'auth_group_type'=>'admin',//认证组类型
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
   *
   * @param string|array $names 待认证规则，C 风格
   * @param integer $userId 待认证用户ID
   * @param string|array|null $authParam  待认证规则参数
   * @param string $relation  认证关系 and or or
   *
   * @return bool|array|integer
   */
  public function check($names,$userId,$authParam=null,$relation='and'){
    /*未开启权限认证*/
    if ( !$this->config[ 'auth_on' ] ) {
      return true;
    }

    /*待认证规则处理*/
    if ( is_string( $names ) ) {
      $names = preg_replace( '/\s+/g','',$names );
      if ( strpos( $names, ',' ) !== false ) {
        $names = explode( ',', $names );
      } else {
        $names = [ $names ];
      }
    }

    // 获取用户需要验证的所有有效规则列表
    $ruleList = $this->getAuthRulesByUserId( $userId );

    /*处理验证参数*/
    if ( !empty( $authParam )){
      if (is_string( $authParam)){
        $authParam=preg_replace( '/\s+/g', '', $authParam);
        $authParam=explode( $this->config['auth_param_delimiter'], $authParam);
      }elseif (!is_array( $authParam)){
        $authParam=[];
      }
    }

    //保存验证通过的规则名
    $authList = [];

    foreach ( $ruleList as $rule ) {

      if ( !empty( $authParam) ) {
        $param= explode( '&', $rule[ 'params' ]);
        $intersect = array_intersect_assoc( $authParam, $param );
        if ( in_array( $rule['name'], $names ) && $intersect === $authParam ) {
          //如果节点相符且参数满足
          $authList[] = $rule['name'];
        }
      } elseif ( in_array( $rule['name'], $names ) ) {
        $authList[] = $rule['name'];
      }
    }
    if ( 'or' === strtolower( $relation) && !empty( $authList ) ) {
      return true;
    }
    $diff = array_diff( $names, $authList );
    if ( 'and' === strtolower( $relation ) && empty( $diff ) ) {
      return true;
    }

    return false;
  }

  public function checkAll( $names, $userId, $authParam = null){
    return $this->check( $names, $userId, $authParam,'and');
  }

  public function checkAny( $names, $userId, $authParam = null){
    return $this->check( $names, $userId, $authParam, 'or' );
  }

  public function getUserInfoByUserId($userId){
    static $user_info = [];

    $user = Db::name( $this->config[ 'auth_user' ] );
    // 获取用户表主键
    $_pk = is_string( $user->getPk() ) ? $user->getPk() : 'uid';
    if ( !isset( $user_info[ $userId ] ) ) {
      $user_info[ $userId ] = $user->where( $_pk, $userId )->find();
    }

    return $user_info[ $userId ];
  }

  public function getGroupsByUserId( $userId){
    static $groups = [];
    if ( isset( $groups[ $userId ] ) ) {
      return $groups[ $userId ];
    }
    // 转换表名
    $auth_group_access = Loader::parseName( $this->config[ 'auth_group_access' ], 1 );
    $auth_group = Loader::parseName( $this->config[ 'auth_group' ], 1 );
    // 执行查询
    $user_groups = Db::view( $auth_group_access, 'uid,group_id' )
                     ->view( $auth_group,
                             'id,pid,name,rules',
                             "{$auth_group_access}.group_id={$auth_group}.id",
                             'LEFT' )
                     ->where( "{$auth_group_access}.uid='{$userId}' and {$auth_group}.status='normal'" )
                     ->select();
    $groups[ $userId ] = $user_groups ? : [];

    return $groups[ $userId ];
  }


  public function getAuthRulesByUserId($userId,$returnType='url'){
    static $authList = array(); //保存用户验证通过的权限列表

    $returnType = $returnType ? strtolower( $returnType): 'url';

    $authListKey= $userId . '_' . $this->config[ 'auth_endpoint' ]. '_'. $this->config[ 'auth_type' ]. '_'. $returnType ;
    /*同一批次访问，直接返回*/
    if ( isset( $authList[ $authListKey ] ) ) {
      return $authList[ $authListKey];
    }
    //登录验证时,返回保存在session的列表
    if ( $this->config[ 'auth_type' ] == 2 && Session::has(  '_auth_rule_list_' . $authListKey  ) ) {
      $authList[ $authListKey ]=Session::get( '_auth_rule_list_' . $authListKey );
      return $authList[ $authListKey ];
    }
    //读取用户所属用户组
    $groupIds = $this->getGroupsByUserId( $userId );
    //保存用户所属用户组设置的所有权限规则id
    $ruleIds = [];
    foreach ( $groupIds as $groupId ) {
      $ruleIds = array_merge( $ruleIds, explode( ',', trim( $groupId[ 'rules' ], ',' ) ) );
    }
    $ruleIds = array_unique( $ruleIds );
    if ( empty( $ruleIds ) ) {
      $authList[ $authListKey ] = [];
      return $authList[ $authListKey ];
    }
    //rules的ids
    $where = array(
      'id'       => array( 'in', $ruleIds ),
      'endpoint'     => $this->config['auth_endpoint'],
    );
    //读取用户组所有权限规则
    $rules = Db::table( '')
      ->name( $this->config[ 'auth_rule' ] )
      ->where( $where )
      ->field( 'id,name,params,condition,http_verb' )
      ->select();
    //循环规则，判断结果。
    $_authList = [];
    foreach ( $rules as $rule ) {
      if ( empty( $rule[ 'condition' ] ) ) {
        $_authList[] = ( $returnType === 'url' ) ? $rule  : $rule[ 'id' ];
      } else {
        $user = $this->getUserInfoByUserId( $userId );//获取用户信息,一维数组
        $command = preg_replace( '/\{(\w*?)\}/', '$user[\'\\1\']', $rule[ 'condition' ] );
        @( eval( '$condition=(' . $command . ');' ) );
        if ( $condition ) {
          $_authList[] = ( $returnType === 'url' ) ? $rule : $rule[ 'id' ];
        }
      }
    }

    $authList[ $authListKey ] = array_unique( $_authList );
    if ( $this->config[ 'auth_type' ] == 2 ) {
      //规则列表结果保存到session
      session( '_auth_rule_list_' . $authListKey, $authList[ $authListKey ] );
    }

    return $authList[ $authListKey ];
  }
}
