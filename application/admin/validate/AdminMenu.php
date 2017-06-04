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
    'id'  => 'require|isPositiveInteger',
    'pid' => 'require|integer'
  ];

  protected $scene = [
    'create' => [ 'pid' ],
    'save'   => [ 'pid' ],
    'edit'   => [ 'id' ],
    'update' => [ 'id', 'pid' ]
  ];

}
