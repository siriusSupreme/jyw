<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 9:06
 */

namespace vendor;


class Upload {
  /*上传配置项*/
  private $config = [
    'root_path'     => '/public',/*上传根目录*/
    'save_path'     => '',/*保存路径*/
    'save_name'     => [],/*保存文件名*/
    'allowed_exts'  => [],/*允许上传的后缀*/
    'allowed_mimes' => [],/*允许上传的类型*/
    'max_size'      => '',/*允许上传最大大小*/
    'driver'        => 'Local',/*上传驱动*/
    'driver_config' => []/*上传驱动配置*/
  ];
  /*待上传文件数组*/
  private $upfiles = [];
  /*单例实例*/
  private static $instance=null;
  /*上传实例*/
  private $uploader=null;

  /**
   * Upload constructor.
   *
   * @param array $config
   * @param string $driver
   * @param array $driverConfig
   */
  public
  function __construct($config=[],$driver='Local',$driverConfig=[]) {
    /**/
    $this->config=array_merge( $this->config,$config);


  }

  /**
   * 获取实例对象
   * @param array $config
   * @param bool $renew
   *
   * @return null|static
   */
  public static function instance($config=[],$renew=false){
    if (self::$instance===null || $renew===true){
      self::$instance=new static();
    }

    return self::$instance;
  }

  /**
   * 设置配置项
   * @param array $config
   *
   * @return $this
   */
  public function setConfig(array $config){
    $this->config=array_merge( $this->config,$config);
    if (!empty( $this->config['allowed_mimes'])){
      if (is_string( $this->config['allowed_mimes'])){
        $this->config['allowed_mimes']=explode( ',', $this->config['allowed_mimes']);
      }

      $this->config[ 'allowed_mimes' ]=array_map( function (), $funcname);
    }
    return $this;
  }


  public
  function upload() {

  }

  /**
   * 获取指定上传字段的上传文件数组
   * @param string $upfields
   *
   * @return $this
   */
  public
  function files( $upfields = '' ) {
    $files = [];

    /*根据上传字段获取上传文件*/
    if ( $upfields === '' ) {
      $files = $_FILES;
    } elseif ( is_string( $upfields ) ) {
      $upfields = explode( ',', $upfields );
      foreach ( $upfields as $upfield ) {
        $files[ $upfield ] = $_FILES[ $upfield ];
      }
    } elseif ( is_array( $upfields ) ) {
      foreach ( $upfields as $upfield ) {
        $files[ $upfield ] = $_FILES[ $upfield ];
      }
    }

    if ( !empty( $files ) && is_array( $files ) ) {
      $index=0;
      /*遍历重组上传文件*/
      foreach ( $files as $key => $file ) {
        /*多文件上传*/
        if ( is_array( $file[ 'name' ] ) ) {
          /*获取数量*/
          $count=count( $file[ 'name' ] );
          /*获取键*/
          $keys=array_keys( $file);
          /*临时文件*/
          $_file=[];
          /*遍历组装*/
          for ($i=0;$i < $count;$i++){
            foreach ($keys as $_key){
              $_file[$_key]=$file[$_key][$i];
            }
            $_file['key']=$key;
            $this->upfiles[ $index++ ]= $_file;
          }
        } else {/*单文件上传*/
          $file[ 'key' ] = $key;
          $this->upfiles[ $index++] = $file;
        }
      }
    }

    return $this;
  }


}
