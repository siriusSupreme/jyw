<?php

namespace app\admin\controller;


use app\common\controller\CommonBase;

class AdminBase extends CommonBase {
  protected
  function _initialize() {
    parent::_initialize(); // TODO: Change the autogenerated stub

    /*获取模板设置*/
    $template = config( 'template' );
    /*设置模板临时缓存目录*/
    $template[ 'cache_path' ] = TEMP_PATH . $this->module . DS . $this->controller . DS;
    /*设置模板缓存*/
    if ( !container()->make( 'config')->get('app.app_debug') ) {
      $template[ 'cache_id' ] = md5( $this->module . DS . $this->controller . DS . $this->action );
      $template[ 'display_cache' ] = true;
    }
    /*设置模板视图根目录*/
    $template[ 'view_base' ] = THEME_PATH . 'admin' . DS . config( 'theme.admin_theme' ) . DS;
    /*设置模板引擎*/
    $this->engine( $template );

    $this->viewReplaceStr = array_merge( $this->viewReplaceStr,
                                         [
                                           "__ADMIN_STATIC__"  => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static',
                                           "__ADMIN_JS__"      => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/js',
                                           "__ADMIN_CSS__"     => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/css',
                                           "__ADMIN_IMAGES__"  => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/images',
                                           "__ADMIN_FONTS__"   => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/fonts',
                                           "__ADMIN_LIBS__"    => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/libs',
                                           "__ADMIN_PLUGINS__" => $this->resourcePrefix
                                                                  . 'theme/admin/'
                                                                  . config( 'theme.admin_theme' )
                                                                  . '/public/static/plugins'
                                         ] );

  }


}
