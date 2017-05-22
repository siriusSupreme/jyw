<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 17:25
 */

namespace app\common\behavior;


class LoadDefinedConfigBehavior {
  /*public function run(&$paramas){
    Config::load( CONFIG_PATH . 'config.php' );
  }*/

  public
  function appInit() {
    $dir = realpath( CONFIG_PATH . 'defined/autoload_by_filename' );
    $hanler = opendir( $dir );
    while ( false !== ( $file = readdir( $hanler ) ) ) {
      if ( $file !== '.' && $file !== '..' ) {
        app( 'config' )->load( $dir . DS . $file, pathinfo( $file, PATHINFO_FILENAME ) );
      }
    }
  }
}
