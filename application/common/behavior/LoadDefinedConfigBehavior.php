<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 17:25
 */

namespace app\common\behavior;


use think\Config;

class LoadDefinedConfigBehavior {
  /*public function run(&$paramas){
    Config::load( CONFIG_PATH . 'config.php' );
  }*/

  public
  function appInit() {
    Config::load( CONFIG_PATH . 'defined/config.php' );
  }
}
