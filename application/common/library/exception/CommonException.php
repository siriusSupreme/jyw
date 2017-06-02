<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 9:45
 */

namespace app\common\library\exception;


use think\Exception;

class CommonException extends Exception {
  protected $code      = 400;
  protected $msg       = 'invalid parameters';
  protected $errorCode = 999;

  protected $shouldToClient = true;

  /**
   * 构造函数，接收一个关联数组
   *
   * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
   */
  public
  function __construct( $params = [] ) {
    if ( !is_array( $params ) ) {
      return;
    }
    if ( array_key_exists( 'code', $params ) ) {
      $this->code = $params[ 'code' ];
    }
    if ( array_key_exists( 'msg', $params ) ) {
      $this->msg = $params[ 'msg' ];
    }
    if ( array_key_exists( 'errorCode', $params ) ) {
      $this->errorCode = $params[ 'errorCode' ];
    }
  }

  public
  function __get( $name ) {
    return isset( $this->$name ) ? $this->$name : '';
  }

  public
  function __isset( $name ) {
    return isset( $this->$name );
  }
}
