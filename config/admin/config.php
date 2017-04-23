<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


/*a:app c:config  m:module  f:file  d:directory*/
/*cmf_config->cmf_database->cmd_extra->cmf_app_status->cmf_tags->amf_common->amf_lang->app_path_func->conf_path_route*/

return [
    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 视图基础目录，配置目录为所有模块的视图起始目录
        'view_base'    => './public/template/admin/default/',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [
      '__PUBLIC_STATIC__'=>'/public/static',
      '__PUBLIC_CSS__'=>'/public/static/css',
      '__PUBLIC_IMAGES__'=>'/public/static/images',
      '__PUBLIC_FONTS__'=>'/public/static/fonts',
      '__PUBLIC_LIBS__'=>'/public/static/libs',
      '__PUBLIC_PLUGINS__'=>'/public/static/plugins',
      '__PUBLIC_JS__'=>'/public/static/js',
      '__ADMIN_CSS__'=>'/public/template/admin/default/public/static/css',
      '__ADMIN_STATIC__'=>'/public/template/admin/default/public/static',
      '__ADMIN_IMAGES__'=>'/public/template/admin/default/public/static/images',
      '__ADMIN_FONTS__'=>'/public/template/admin/default/public/static/fonts',
      '__ADMIN_LIBS__'=>'/public/template/admin/default/public/static/libs',
      '__ADMIN_PLUGINS__'=>'/public/template/admin/default/public/static/plugins',
      '__ADMIN_JS__'=>'/public/template/admin/default/public/static/js'
    ],

];
