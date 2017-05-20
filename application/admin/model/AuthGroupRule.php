<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 15:38
 */

namespace app\admin\model;


class AuthGroupRule extends AdminBase {
  public function groups(){
    return $this->morphTo('group',['admin'=>'app\admin\model\AdminGroupModel']);
  }
}
