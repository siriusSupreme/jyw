<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 15:38
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class AuthRuleModel extends AdminBaseModel {
  public function ruleBelongsToGroups(){
    return $this->hasMany( 'AuthGroupRuleModel','auth_rule_id','id');
  }
}
