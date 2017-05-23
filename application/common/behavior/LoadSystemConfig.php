<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 17:25
 */

namespace app\common\behavior;


class LoadSystemConfig {
  /*public function run(&$paramas){
    Config::load( CONFIG_PATH . 'system/config.php' );
  }*/

  public
  function appInit() {
    $dir = realpath( CONFIG_PATH . 'system' );
    $files = scandir( $dir );
    foreach ( $files as $file ) {
      if ( $file !== '.' && $file !== '..' ) {
        $autoDir = $dir . DS . $file;
        if ( is_dir( $autoDir ) ) {
          $autoFiles = scandir( $autoDir );
          foreach ( $autoFiles as $autoFile ) {
            if ( $autoFile !== '.' && $autoFile !== '..' ) {
              app('config')->load( $autoDir . DS . $autoFile, pathinfo( $autoFile, PATHINFO_FILENAME ) );
            }
          }
        } else {
          app( 'config' )->load( $autoDir, pathinfo( $autoDir, PATHINFO_FILENAME ) );
        }
      }
    }
  }
}
