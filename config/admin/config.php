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

//app_debug
//class_suffix

return [

// 默认输出类型
'default_return_type'    => 'html',
// 默认AJAX 数据返回格式,可选json xml ...
'default_ajax_return'    => 'json',
// 是否开启多语言
'lang_switch_on'         => false,
// 默认全局过滤方法 用逗号分隔多个
'default_filter'         => '',
// 默认语言
'default_lang'           => 'zh-cn',
// 自动搜索控制器
'controller_auto_search' => true,
// pathinfo分隔符
'pathinfo_depr'          => '/',
// URL伪静态后缀
'url_html_suffix'        => 'html',
// URL普通方式参数 用于自动生成
'url_common_param'       => false,
// URL参数方式 0 按名称成对解析 1 按顺序解析
'url_param_type'         => 0,
// 是否开启路由
'url_route_on'           => true,
// 路由配置文件（支持配置多个）
'route_config_file'      => [ 'route' ],
// 路由使用完整匹配
'route_complete_match'   => false,
// 是否强制使用路由
'url_route_must'         => false,
// 域名部署
'url_domain_deploy'      => false,
// 域名根，如thinkphp.cn
'url_domain_root'        => '',
// 是否自动转换URL中的控制器和操作名
'url_convert'            => false,

];
