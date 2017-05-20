<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 9:52
 */

namespace app\admin\model;



class AdminGroup extends AdminBase {

  public function admins(){
    return $this->belongsToMany( 'AdminModel', 'admin_group_access','admin_id','admin_group_id');
  }

  public function authGroupRules(){
    return $this->morphMany( 'AuthGroupRuleModel','group','admin');
  }

}
