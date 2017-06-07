<?php

namespace app\admin\validate;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 15:53
 */
class AdminMenu extends AdminBase {
  protected $rule = [
    'id'  => 'require',
    'pid' => 'require|integer',
    'name'=>'require'
  ];

  protected $message=[];

  protected $field=[];

  protected $scene = [
    'create' => [ 'pid' ],
    'save'   => [ 'pid', 'name', 'title', 'url', 'icon', 'target', 'status', 'params', 'list_order', 'is_need_check' ],
    'edit'   => [ 'id' ],
    'update' => [ 'id','pid', 'name', 'title', 'url', 'icon', 'target', 'status', 'params', 'list_order', 'is_need_check' ],
    'delete'=>['id']
  ];

}
