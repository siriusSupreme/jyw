<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 11:36
 */

namespace app\admin\model;



class AlbumResource extends AdminBase {
  public function album(){
    return $this->belongsTo( 'Album');
  }
}
