<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 9:52
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class AdminGroupModel extends AdminBaseModel {

  public function admins(){
    return $this->belongsToMany( 'Admin', 'admin_group_access');
  }

}
