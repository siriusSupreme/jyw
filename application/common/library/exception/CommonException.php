<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 9:45
 */

namespace app\common\library\exception;


use app\common\library\constant\ErrorCode;
use app\common\library\constant\StatusCode;
use think\Exception;

class CommonException extends Exception {
  protected $statusCode = StatusCode::BAD_REQUEST;
  protected $errorCode  = ErrorCode::UNKNOWN_ERROR;
  protected $msg        = '';

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
    if ( array_key_exists( 'status_code', $params ) ) {
      $this->statusCode = $params[ 'status_code' ];
    }
    if ( array_key_exists( 'error_code', $params ) ) {
      $this->errorCode = $params[ 'error_code' ];
    }
    if ( array_key_exists( 'msg', $params ) ) {
      $this->msg = empty( $params[ 'msg' ] ) ? ErrorCode::getTextByErrorCode( $this->errorCode ) : $params[ 'msg' ];
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
