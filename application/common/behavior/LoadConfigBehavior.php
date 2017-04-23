<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 17:25
 */

namespace app\common\behavior;


class LoadConfigBehavior {
  public function run(&$paramas){
    echo $paramas;
    exit( );
  }

  public
  function appInit(&$paramas) {
    var_dump( $paramas);
    exit();
  }
}
