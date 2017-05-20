<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 11:35
 */

namespace app\admin\model;



class Album extends AdminBase {
  public function albumResources(){
    return $this->hasMany('AlbumResource');
  }
}
