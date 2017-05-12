<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 9:51
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class AdminModel extends AdminBaseModel {

  public function adminGroups(){
    return $this->belongsToMany( 'AdminGroupModel','admin_group_access','admin_group_id','admin_id');
  }

}
