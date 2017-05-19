<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 10:00
 */

namespace app\common\library\exception;


use Exception;
use think\exception\Handle;

class BaseExceptionHandle extends Handle {

  public function render( Exception $e ) {

  }
}
