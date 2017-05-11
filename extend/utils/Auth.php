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

  }
}
