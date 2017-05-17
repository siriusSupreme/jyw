<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 9:47
 */

namespace vendor\upload\driver;


class Local {

  private $error = ''; //上传错误信息

  /**
   * 构造函数，用于设置上传根路径
   */
  public
  function __construct( $config = null ) {

  }


  /**
   * 检测上传目录
   *
   * @param $file
   *
   * @return bool
   */
  public
  function checkPath( $file ) {
    /* 检测并创建目录 */
    $dir= dirname( $file[ 'root_path' ] . $file[ 'save_path' ] . $file[ 'save_name' ] );

    if ( !is_dir( $dir )){
      if (!mkdir( $dir,0666,true)){
        $this->error= "目录 {$dir} 创建失败！";
        return false;
      }
    }elseif( !is_writeable( $dir )){
      $this->error = '上传目录 ' . $dir . ' 不可写！';
      return false;
    }

    return true;
  }

  /**
   * 保存指定文件
   *
   * @param  array $file      保存的文件信息
   * @param  boolean $replace 同名文件是否覆盖
   *
   * @return boolean          保存状态，true-成功，false-失败
   */
  public
  function save( $file, $replace = true ) {
    $filename =  $file[ 'root_path' ] . $file[ 'save_path' ]  . $file[ 'save_name' ];

    /* 不覆盖同名文件 */
    if ( !$replace && is_file( $filename ) ) {
      $this->error = '存在同名文件' . $file[ 'save_name' ];

      return false;
    }

    /* 移动文件 */
    if ( !move_uploaded_file( $file[ 'tmp_name' ], $filename ) ) {
      $this->error = '文件上传保存错误！';

      return false;
    }

    return true;
  }


  /**
   * 获取最后一次上传错误信息
   * @return string 错误信息
   */
  public
  function getError() {
    return $this->error;
  }
}
