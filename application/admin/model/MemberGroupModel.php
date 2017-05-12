<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 17:26
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class MemberGroupModel extends AdminBaseModel {
  public function members(){
    return $this->hasMany( 'MemberModel','member_group_id','id');
  }
}
