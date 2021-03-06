<?php

namespace app\admin\validate;

use app\admin\library\exception\ParameterException;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 15:05
 */
class AdminBase extends Validate {

  private $params = [];

  /**
   * 检测所有客户端发来的参数是否符合验证类规则
   * 基类定义了很多自定义验证方法
   * 这些自定义验证方法其实，也可以直接调用library
   * @throws ParameterException
   * @return true
   */
  public
  function goCheck( $scene = '', $batch = false ) {
    //必须设置contetn-type:application/json
    $request = request();
    $this->params = $request->param();
    $this->params[ 'token' ] = $request->header( 'token' );

    if ( !$this->scene( $scene )->batch( $batch )->check( $this->params ) ) {
      $exception = new ParameterException(
        [
          // $this->error有一个问题，并不是一定返回数组，需要判断
          'msg' => is_array( $this->error ) ? implode(
            ';',
            $this->error ) : $this->error,
        ] );
      throw $exception;
    }

    return true;
  }

  /**
   * @return array 按照规则key过滤后的变量数组
   * @throws ParameterException
   */
  public
  function getDataByScene( $scene = '' ) {
    $data = $this->params;

    if ( array_key_exists( 'user_id', $data ) | array_key_exists( 'uid', $data ) ) {
      // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
      throw new ParameterException( [
                                      'msg' => '参数中包含有非法的参数名user_id或者uid'
                                    ] );
    }

    $rule = $this->getScene( $scene );
    $rule = empty( $rule ) ? array_keys( $this->rule ) : $rule;

    $newArray = [];
    foreach ( $rule as $value ) {
      $newArray[ $value ] = isset( $data[ $value ] ) ? $data[ $value ] : '';
    }

    return $newArray;
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
      return false;
    } else {
      return true;
    }
  }

  //没有使用TP的正则验证，集中在一处方便以后修改
  //不推荐使用正则，因为复用性太差
  //手机号的验证规则
  protected
  function isMobile( $value ) {
    $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
    $result = preg_match( $rule, $value );
    if ( $result ) {
      return true;
    } else {
      return false;
    }
  }


}
