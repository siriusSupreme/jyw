<?php
/**
 * Created by PhpStorm.
 * User: 七月
 * Date: 2017/2/12
 * Time: 18:29
 */

namespace app\admin\library\exception;

use app\common\library\constant\ErrorCode;
use app\common\library\constant\StatusCode;
use app\common\library\exception\CommonException;

/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParameterException extends CommonException {
  protected $statusCode      = StatusCode::BAD_REQUEST;
  protected $errorCode = ErrorCode::PARAMETER_ERROR;
  protected $msg       = "invalid parameters";
}
