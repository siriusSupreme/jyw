<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 11:35
 */

namespace app\admin\model;


use app\common\model\AdminBaseModel;

class AlbumModel extends AdminBaseModel {
  public function albumResources(){
    return $this->hasMany('AlbumResource');
  }
}
