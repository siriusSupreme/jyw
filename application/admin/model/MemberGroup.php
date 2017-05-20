<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 17:26
 */

namespace app\admin\model;



class MemberGroup extends AdminBase {
  public function members(){
    return $this->hasMany( 'MemberModel','member_group_id','id');
  }
}
