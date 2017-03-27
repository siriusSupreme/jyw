<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 9:06
 */

namespace vendor\upload;


use think\Config;
use think\exception\ClassNotFoundException;

class Upload {
  /*上传配置项*/
  private $config = [
    'root_path'     => '/public',/*上传根目录*/
    'save_path'     => '',/*保存路径*/
    'save_name'     => [ 'date' ],/*保存文件名*/
    'allowed_exts'  => [],/*允许上传的后缀*/
    'allowed_mimes' => [],/*允许上传的类型*/
    'max_size'      => '',/*允许上传最大大小*/
    'driver'        => 'Local',/*上传驱动*/
    'driver_config' => []/*上传驱动配置*/
  ];
  /*待上传文件数组*/
  private $upfiles = [];
  /*单例实例*/
  private static $instance = null;
  /*上传实例*/
  private static $uploader = null;
  /*上传出错信息*/
  private $error = '';

  /**
   * Upload constructor.
   *
   * @param array $config
   * @param string $driver
   * @param array $driverConfig
   */
  public
  function __construct( $config = [] ) {
    $_config = Config::get( 'upload' );
    if ( !empty( $_config ) && is_array( $_config ) ) {
      $config = array_merge( $_config, $config );
    }
    $this->setConfig( $config );
  }

  /**
   * 获取实例对象
   *
   * @param array $config
   * @param bool $renew
   *
   * @return null|static
   */
  public static
  function instance( $config = [], $renew = false ) {
    if ( self::$instance === null || $renew === true ) {
      self::$instance = new static( $config );
    }

    return self::$instance;
  }

  /**
   * 设置配置项
   *
   * @param array $config
   *
   * @return $this
   */
  public
  function setConfig( array $config ) {
    /*参数配置*/
    $this->config = array_merge( $this->config, $config );
    /*处理 MIME 类型*/
    if ( !empty( $this->config[ 'allowed_mimes' ] ) ) {
      if ( is_string( $this->config[ 'allowed_mimes' ] ) ) {
        $this->config[ 'allowed_mimes' ] = explode( ',', $this->config[ 'allowed_mimes' ] );
      }

      $this->config[ 'allowed_mimes' ] = array_map( function ( $val ) {
        return strtolower( $val );
      },
        $this->mimes );
    }
    /*处理文件后缀*/
    if ( !empty( $this->config[ 'allowed_exts' ] ) ) {
      if ( is_string( $this->config[ 'allowed_exts' ] ) ) {
        $this->config[ 'allowed_exts' ] = explode( ',', $this->config[ 'allowed_exts' ] );
      }

      $this->config[ 'allowed_exts' ] = array_map( function ( $val ) {
        return ltrim( strtolower( $val ), '.' );
      },
        $this->mimes );
    }
    /*驱动配置*/
    $this->setDriver();

    return $this;
  }

  /**
   * 驱动配置
   *
   * @param string $driver
   * @param array $driver_config
   *
   * @return $this
   */
  public
  function setDriver( $driver = '', $driver_config = [] ) {
    if ( !empty( $driver ) && is_string( $driver ) ) {
      $this->config[ 'driver' ] = $driver;
    }

    if ( !empty( $driver_config ) && is_array( $driver_config ) ) {
      $this->config[ 'driver_config' ] = array_merge( $this->config[ 'driver_config' ], $driver_config );
    }

    $class = strpos( $this->config[ 'driver' ], '\\' ) ? $this->config[ 'driver' ] :
      'vendor\\upload\\driver\\' . $this->config[ 'driver' ];
    if ( class_exists( $class ) ) {
      self::$uploader = new $class( $this->config[ 'driver_config' ] );
    } else {
      throw new ClassNotFoundException( 'class not exists: ' . $class, $class );
    }

    return $this;
  }

  public
  function __get( $name ) {
    return $this->config[ $name ];
  }

  public
  function __set( $name, $value ) {
    if ( isset( $this->config[ $name ] ) ) {
      $this->config[ $name ] = $value;
      if ( $name === 'driver_config' ) {
        $this->setDriver();
      }
    }
  }

  public
  function __isset( $name ) {
    return isset( $this->config[ $name ] );
  }


  public
  function upload() {
    $resultArray = [];
    /*获取上传文件*/
    if ( empty( $this->upfiles ) ) {
      $this->files();
    }
    /*文件上传流程*/
    foreach ( $this->upfiles as $file ) {
      if ( !$this->check( $file ) ) {
        continue;
      }
      /*6、创建文件保存路径*/
      if ( !self::$uploader->checkPath() ) {
        $this->error = self::$uploader->getError();
        continue;
      }
      /*7、生成文件保存名*/
      $filename = $this->buildSaveName();
      /*8、开始上传*/
      if ( move_uploaded_file( $filename, '' ) ) {/*上传成功*/

      } else {/*上传失败*/
        $this->error = '文件上传失败';
      }
    }

    return $resultArray;
  }

  private
  function check( $file ) {
    /*1、检测上传错误*/
    if ( $file[ 'error' ] > 0 ) {
      $this->error( $file[ 'error' ] );

      return false;
    }

    if ( empty( $file[ 'tmp_name' ] ) || !is_file( $file[ 'tmp_name' ] ) || empty( $file[ 'name' ] ) ) {
      $this->error = '没有文件被上传';

      return false;
    }

    if ( !is_uploaded_file( $file[ 'tmp_name' ] ) ) {
      $this->error = '非法上传文件';

      return false;
    }
    /*2、文件大小检测*/
    if ( $this->checkSize( $file ) ) {
      $this->error = '文件大小超出限制';

      return false;
    }
    /*3、文件后缀检测*/
    if ( $this->checkExt( $file ) ) {
      $this->error = '文件后缀不被允许';

      return false;
    }
    /*4、文件类型检测*/
    if ( $this->checkMime( $file ) ) {
      $this->error = '文件类型不被允许';

      return false;
    }
    /*5、图片真实性检测*/
    if ( $this->checkImg( $file ) ) {
      $this->error = '不是真实图片';

      return false;
    }

    return true;
  }

  /**
   * 获取错误代码信息
   *
   * @param string $errorNo 错误号
   */
  private
  function error( $errorNo ) {
    switch ( $errorNo ) {
      case 1:
        $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值！';
        break;
      case 2:
        $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值！';
        break;
      case 3:
        $this->error = '文件只有部分被上传！';
        break;
      case 4:
        $this->error = '没有文件被上传！';
        break;
      case 6:
        $this->error = '找不到临时文件夹！';
        break;
      case 7:
        $this->error = '文件写入失败！';
        break;
      default:
        $this->error = '未知上传错误！';
    }
  }

  /**
   * 检测上传文件大小
   *
   * @param $file
   *
   * @return bool
   */
  private
  function checkSize( $file ) {
    if ( $this->config[ 'max_size' ] != 0 && $file[ 'size' ] > $this->config[ 'max_size' ] ) {
      return false;
    }

    return true;
  }

  /**
   * 检测上传文件后缀
   *
   * @param $file
   *
   * @return bool
   */
  private
  function checkExt( $file ) {
    $extension = strtolower( pathinfo( $file[ 'name' ], PATHINFO_EXTENSION ) );
    if ( !in_array( $extension, $this->config[ 'allowed_exts' ] ) && !empty( $this->config[ 'allowed_exts' ] ) ) {
      return false;
    }

    return true;
  }

  /**
   * 检测上传文件类型
   *
   * @param $file
   *
   * @return bool
   */
  private
  function checkMime( $file ) {
    if ( !in_array( strtolower( $file[ 'type' ] ), $this->config[ 'allowed_mimes' ] )
         && !empty( $this->config[ 'allowed_mimes' ] )
    ) {
      return false;
    }

    return true;
  }

  /**
   * 检测图像文件
   *
   * @param $file
   *
   * @return bool
   */
  private
  function checkImg( $file ) {
    $extension = strtolower( pathinfo( $file[ 'name' ], PATHINFO_EXTENSION ) );
    /* 对图像文件进行严格检测 */
    if ( in_array( $extension, [ 'gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf' ] )
         && !in_array( $this->getImageType( $file[ 'tmp_name' ] ), [ 1, 2, 3, 4, 6 ] )
    ) {
      return false;
    }

    return true;
  }

  // 判断图像类型
  private
  function getImageType( $image ) {
    if ( function_exists( 'exif_imagetype' ) ) {
      return exif_imagetype( $image );
    } else {
      $info = getimagesize( $image );

      return $info[ 2 ];
    }
  }


  /**
   * 获取文件的哈希散列值
   * @return $string
   */
  private
  function hash( $type = 'sha1' ) {
    if ( !isset( $this->hash[ $type ] ) ) {
      $this->hash[ $type ] = hash_file( $type, $this->filename );
    }

    return $this->hash[ $type ];
  }

  public
  function __call( $method, $args ) {
    return $this->hash( $method );
  }


  /**
   * 获取保存文件名
   *
   * @param  string|bool $savename 保存的文件名 默认自动生成
   *
   * @return string
   */
  protected
  function buildSaveName( $savename=true ) {
    if ( true === $savename ) {
      // 自动生成文件名
      if ( $this->rule instanceof \Closure ) {
        $savename = call_user_func_array( $this->rule, [ $this ] );
      } else {
        switch ( $this->rule ) {
          case 'date':
            $savename = date( 'Ymd' ) . DS . md5( microtime( true ) );
            break;
          default:
            if ( in_array( $this->rule, hash_algos() ) ) {
              $hash = $this->hash( $this->rule );
              $savename = substr( $hash, 0, 2 ) . DS . substr( $hash, 2 );
            } elseif ( is_callable( $this->rule ) ) {
              $savename = call_user_func( $this->rule );
            } else {
              $savename = date( 'Ymd' ) . DS . md5( microtime( true ) );
            }
        }
      }
    } elseif ( '' === $savename ) {
      $savename = $this->getInfo( 'name' );
    }
    if ( !strpos( $savename, '.' ) ) {
      $savename .= '.' . pathinfo( $this->getInfo( 'name' ), PATHINFO_EXTENSION );
    }

    return $savename;
  }

  /**
   * 获取指定上传字段的上传文件数组
   *
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
      $index = 0;
      /*遍历重组上传文件*/
      foreach ( $files as $key => $file ) {
        /*多文件上传*/
        if ( is_array( $file[ 'name' ] ) ) {
          /*获取数量*/
          $count = count( $file[ 'name' ] );
          /*获取键*/
          $keys = array_keys( $file );
          /*临时文件*/
          $_file = [];
          /*遍历组装*/
          for ( $i = 0; $i < $count; $i++ ) {
            foreach ( $keys as $_key ) {
              $_file[ $_key ] = $file[ $_key ][ $i ];
            }
            $_file[ 'key' ] = $key;
            $this->upfiles[ $index++ ] = $_file;
          }
        } else {/*单文件上传*/
          $file[ 'key' ] = $key;
          $this->upfiles[ $index++ ] = $file;
        }
      }
    }

    return $this;
  }


}
