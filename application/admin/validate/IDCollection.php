<?php
/**
 * Created by Z2y3ystem.
 * User: Acer
 * Date: 2017/5/22
 * Time: 9:08
 */

namespace app\admin\validate;


class IDCollection extends AdminBase {
  protected $rule    = [
    'id' => 'require|checkIDs'
  ];

  protected $field=[
    'id'=>'主键'
  ];

  protected $message = [
    'id' => 'id必须为以逗号分隔的正整数或整型数组'
  ];

  //id = id1,id2...... or [id1,id2......]
  protected
  function checkIDs( $value ) {
    if ( !is_array( $value ) ) {
      $value = explode( ',', $value );
    }

    if ( empty( $value ) ) {
      return false;
    }

    foreach ( $value as $id ) {
      if ( true!==$this->isPositiveInteger( $id ) ) {
        return false;
      }
    }

    return true;
  }
}
