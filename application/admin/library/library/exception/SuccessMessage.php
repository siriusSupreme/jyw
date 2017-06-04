<?php
/**
 * Created by 七月
 * Author: 七月
 * Date: 2017/2/18
 * Time: 15:44
 */

namespace app\admin\library\exception;

use app\common\library\constant\ErrorCode;
use app\common\library\constant\StatusCode;
use app\common\library\exception\CommonException;

/**
 * 创建成功（如果不需要返回任何消息）
 * 201 创建成功，202需要一个异步的处理才能完成请求
 */
class SuccessMessage extends CommonException {
  protected $code      = StatusCode::CREATED;
  protected $errorCode = ErrorCode::SUCCESS;
  protected $msg       = 'success';
}
