<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/6
 * Time: 16:16
 */

namespace app\demo\controller;


class UserController extends BaseController {

  public $restMethodList='get|post|delete';

  public function get(){
    return $this->sendSuccess(['name'=>'sirius','id'=>1]);
  }

  public function post(){
    return $this->sendError( 400, '用户名不能为空' );
  }
}
