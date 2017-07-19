<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 10:00
 */

namespace app\common\library\exception;

use app\common\library\constant\ErrorCode;
use app\common\library\constant\StatusCode;
use Exception;
use think\exception\Handle;

class ExceptionHandle extends Handle {

  private $statusCode;
  private $errorCode;
  private $msg;

  public
  function render( Exception $e ) {
    if ( $e instanceof CommonException ) {
      //如果是自定义异常，则控制http状态码，不需要记录日志
      //因为这些通常是因为客户端传递参数错误或者是用户请求造成的异常
      //不应当记录日志

      $this->statusCode = $e->statusCode;
      $this->errorCode = $e->errorCode;
      $this->msg = $e->msg;
    } else {
      // 如果是服务器未处理的异常，将http状态码设置为500，并记录日志
      if ( app()->isDebug() ) {
        // 调试状态下需要显示TP默认的异常页面，因为TP的默认页面
        // 很容易看出问题
        return parent::render( $e );
      }

      $this->statusCode = StatusCode::INTERNAL_SERVER_ERROR;
      $this->errorCode = ErrorCode::UNKNOWN_ERROR;
      $this->msg = 'sorry，we make a mistake. (^o^)Y';
      $this->recordErrorLog( $e );
    }

    $request =request();
    $result = [
      'msg'         => $this->msg,
      'error_code'  => $this->errorCode,
      'request_url' => $request->url(),
      'time'=>$_SERVER['REQUEST_TIME']
    ];

    return json( $result, $this->statusCode );
  }

  /*
   * 将异常写入日志
   */
  private
  function recordErrorLog( Exception $e ) {
    app('log')->init( [
                 'type'  => 'File',
                 'path'  => LOG_PATH,
                 'level' => [ 'error' ]
               ] );
//        app('log')->record($e->getTraceAsString());
    app('log')->record( $e->getMessage(), 'error' );
  }
}
