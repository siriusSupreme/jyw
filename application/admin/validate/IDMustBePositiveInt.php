<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 15:45
 */

namespace app\admin\validate;


class IDMustBePositiveInt extends AdminBase {
  protected $rule    = [
    'id' => 'require|isPostiveInteger'
  ];

  protected $field=[
    'id'=>'主键'
  ];

  protected $message = [
    'id' => 'id必须是正整数'
  ];
}
