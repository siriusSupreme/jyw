<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 10:16
 */

namespace app\api\controller\v1;


use vendor\upload\Upload as BaseUpload;

class Upload  {


  public function upload(){
    $result= BaseUpload::instance( [ 'save_path' => 'avatar' ])->upload();
    //$this->result( $result);
    var_dump( $result);
  }
}
