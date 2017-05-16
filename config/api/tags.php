<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/29
 * Time: 16:54
 */
return [
  // 应用初始化
  'app_init'     => ['app\\api\\behavior\\CORSBehavior'],
  // 应用开始
  'app_begin'    => [],
  // 模块初始化
  'module_init'  => [],
  // 操作开始执行
  'action_begin' => [],
  // 视图内容过滤
  'view_filter'  => [],
  // 应用结束
  'app_end'      => [],
  // 日志写入
  'log_write'    => [],
  //响应结束
  'resopnse_end' => []
];
