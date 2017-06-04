<?php
namespace app\common\library\constant;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 9:32
 */
class ErrorCode {
  const OK = 0;
  const SUCCESS=0;
  const PARAMETER_ERROR=10000;
  const NOT_FOUND=10001;
  const UNKNOWN_ERROR=99999;

  private static $errorCodeMap=[
    0=>'success',
    10000=>'参数错误',
    10001=>'资源未找到',
    99999=>'未知错误'
  ];

  public static function getTextByErrorCode($error_code){
    return array_key_exists( $error_code, self::$errorCodeMap) ? self::$errorCodeMap[ $error_code ] : '此错误码暂无描述';
  }

}
