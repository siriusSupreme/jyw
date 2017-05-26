<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 16:26
 */

namespace app\admin\validate;


use think\Validate;

class AdminBase extends Validate {

  public function goCheck(){

  }


  protected
  function isPositiveInteger( $value, $rule = '', $data = '', $field = '' ) {
    if ( is_numeric( $value ) && is_int( $value + 0 ) && ( $value + 0 ) > 0 ) {
      return true;
    }

    return $field . '必须是正整数';
  }

  protected
  function isNotEmpty( $value, $rule = '', $data = '', $field = '' ) {
    if ( empty( $value ) ) {
      return $field . '不允许为空';
    } else {
      return true;
    }
  }
}
