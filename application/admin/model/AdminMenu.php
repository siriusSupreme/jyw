<?php

namespace app\admin\model;


class AdminMenu extends AdminBase {

  protected
  function initialize() {
    parent::initialize(); // TODO: Change the autogenerated stub
  }

  protected static
  function init() {
    parent::init(); // TODO: Change the autogenerated stub


    self::event( 'after_insert',
      function ( $model ) {
        if ( $model->pid == 0 ) {
          $model->path = '0-' . $model->id;
        } else {
          $pModel = self::get( $model->pid );
          $model->path = $pModel->path . '-' . $model->id;
        }
        $model->allowField( true )->save();
      } );

    self::afterUpdate( function ( $model ) {
      /*pid 发生变化说明层级关系改变*/
      $model=self::get( $model->id);
      $prevPathArray = explode( '-', $model->path );
      $prevPid = array_slice( $prevPathArray, -2, 1 )[ 0 ];
      $currentPid = $model->pid;

      /**
       * 0-1          1   0
       * 0-1-3        3   1
       * 0-1-4        4   1
       * 0-1-4-7      7   4
       * 0-1-4-7-11   11  7
       * 0-1-4-7-12   12  7
       * 0-1-4-8      8   4
       * 0-1-4-9      9   4
       * 0-1-4-9-10   10  7
       * 0-2          2   0
       * 0-2-5        5   2
       * 0-2-6        6   2
       * 0-2-6-13     13  6
       */
      if ( $prevPid != $currentPid ) {
        $pModel = self::get( $model->pid );
        /*更新为自己子级的子级*/
        if ( !empty( $pModel ) && strpos( $pModel->path, $model->path . '-' ) === 0 ) {
          $cModel = self::all( ['pid'=>$model->id] );
          $pathArray = explode( '-', $model->path );
          foreach ( $cModel as $item ) {
            array_pop( $pathArray );
            array_push( $pathArray, $item->id );
            $item->path = implode( '-', $pathArray );
            $item->pid = $prevPid;
            $item->allowField( true )->save();
          }
        } else {
          //$model->path = ( $prevPid == 0 ? '0' : ( self::get( $model->pid ) )->path ) . '-' . $model->id;
          $model->path = ( $currentPid == 0 ? '0' : ( self::get( $model->pid ) )->path ) . '-' . $model->id;
          $model->allowField( true )->save();
        }
      }

      /*获取并更新子级*/
      $cModel = self::all( [ 'pid' => $model->id ] );
      if ( !empty( $cModel ) ) {
        foreach ( $cModel as $item ) {
          if ( substr_compare( $item->path, $model->path . '-' . $item->id, 0 ) !== 0 ) {
            $item->path = $model->path . '-' . $item->id;
            $item->allowField( true )->save();
          } else {
            break;
          }
        }
      }
    } );
  }

  protected
  function setStatusAttr( $value, $data ) {
    return $value == 'on' ? 1 : 0;
  }

  protected
  function setIsNeedCheckAttr( $value, $data ) {
    return $value == 'on' ? 1 : 0;
  }

  protected
  function setParamsAttr( $value, $data ) {
    //return preg_replace( "/,(\w+=)/", "&$1", $value);

    return preg_replace( "/,(?=\w+=[^,]+)/", "&", $value );
  }

  public static
  function getMenuList() {
    $list = self::column( 'id,name,url,params', 'id' );

    return $list;
  }

  public static
  function getMenuListByPage() {
    $list = self::column( 'id,name,url,params', 'id' );

    return $list;
  }


}
