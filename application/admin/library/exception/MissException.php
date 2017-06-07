<?php
/**
 * Created by 七月.
 * User: 七月
 * Date: 2017/2/14 我去，情人节，886214
 * Time: 1:03
 */

namespace app\admin\library\exception;

use app\common\library\constant\ErrorCode;
use app\common\library\constant\StatusCode;
use app\common\library\exception\CommonException;

/**
 * 404时抛出此异常
 */
class MissException extends CommonException {
  public $code      = StatusCode::NOT_FOUND;
  public $errorCode = ErrorCode::NOT_FOUND;
  public $msg       = 'global:your required resource are not found';
}
