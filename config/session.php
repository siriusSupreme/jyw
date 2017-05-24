<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/22
 * Time: 16:14
 */

return [
  'id'             => '',
  // SESSION_ID的提交变量,解决flash上传跨域
  'var_session_id' => '',
  // SESSION 前缀
  'prefix'         => 'think',
  // 驱动方式 支持redis memcache memcached
  'type'           => '',
  // 是否自动开启 SESSION
  'auto_start'     => true,
  'httponly'       => true,
  'secure'         => false,
  'use_trans_sid'=>true
];
