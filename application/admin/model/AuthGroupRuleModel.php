<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 15:38
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class AuthGroupRuleModel extends AdminBaseModel {
  public function groups(){
    return $this->morphTo('group',['admin'=>'app\admin\model\AdminGroupModel']);
  }
}
