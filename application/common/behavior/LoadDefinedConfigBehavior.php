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
    $dir=realpath( CONFIG_PATH.'defined/autoload_by_filename');
    $hanler=opendir( $dir);
    while(false!==($file=readdir($hanler))){
      if($file!=='.'&&$file!=='..'){
        Config::load( $dir.DS.$file ,pathinfo( $file,PATHINFO_FILENAME));
      }
    }
  }
}
