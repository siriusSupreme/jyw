<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 16:33
 */
return [
  'type'    => 'complex',
  'default' => [// 驱动方式
                'type'   => 'File',
                'cache_subdir'=>false,
                'data_compress'=>false,
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

];
