<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 16:17
 */

namespace app\admin\validate;


class AdminMenu extends AdminBase {
  protected $rule=[
    'pid'=>'require'
  ];
  protected $message=[];
  protected $scene=[];
}
