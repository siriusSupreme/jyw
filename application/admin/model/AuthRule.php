<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 15:38
 */

namespace app\admin\model;


class AuthRule extends AdminBase {
  public function ruleBelongsToGroups(){
    return $this->hasMany( 'AuthGroupRuleModel','auth_rule_id','id');
  }
}
