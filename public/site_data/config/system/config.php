<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 15:13
 */

return [
  'app_debug'=>true,
  'app_trace'=>true,
  'app_status'=>'debug',
  'lang_switch_on'=>true,
  'pathinfo_depr'=>'/',
  'url_html_suffix'=>'html',

  // +----------------------------------------------------------------------
  // | 缓存设置
  // +----------------------------------------------------------------------

  'cache' => [
    'type'    => 'complex',
    'default' => [// 驱动方式
                  'type'   => 'File',
                  // 缓存保存目录
                  'path'   => CACHE_PATH,
                  // 缓存前缀
                  'prefix' => '',
                  // 缓存有效期 0表示永久缓存
                  'expire' => 0 ],
    'file'    => [// 驱动方式
                  'type'   => 'File',
                  // 缓存保存目录
                  'path'   => CACHE_PATH,
                  // 缓存前缀
                  'prefix' => '',
                  // 缓存有效期 0表示永久缓存
                  'expire' => 0 ]

  ],
];
