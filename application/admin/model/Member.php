<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 17:26
 */

namespace app\admin\model;


class Member extends AdminBase {
  public function getGroup(){
    return $this->belongsTo( 'MemberGroupModel','member_group_id','id');
  }
}
