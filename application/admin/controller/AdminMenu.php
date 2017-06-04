<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\AdminMenu as AdminMenuModel;
use app\admin\validate\AdminMenu as AdminMenuValidate;
use utils\Tree;

class AdminMenu extends AdminBase {
  /**
   * 显示资源列表
   *
   * @return \think\Response
   */
  public
  function index() {

    return $this->fetch();
  }

  /**
   * 显示创建资源表单页.
   *
   * @return \think\Response
   */
  public
  function create( $pid ) {
    /*参数验证*/
    ( new AdminMenuValidate() )->goCheck( 'create' );

    /*获取菜单列表*/
    $lists = AdminMenuModel::all()->toArray();
    $trees = Tree::instance( $lists )->makeOption( 0, $pid);

    $this->assign( [
      'option_tree'=>$trees
                   ]);
    return $this->fetch();
  }

  /**
   * 保存新建的资源
   *
   * @param  \think\Request $request
   *
   * @return \think\Response
   */
  public
  function save( Request $request ) {
    ( new AdminMenuValidate() )->goCheck( 'save' );

    $result = AdminMenuModel::create( input( 'post.' ), true );

    return json( [ 'error_code' => 0, 'msg' => '菜单新增成功' ] );
  }

  /**
   * 显示指定的资源
   *
   * @param  int $id
   *
   * @return \think\Response
   */
  public
  function read( $id ) {
    return $this->fetch();
  }

  /**
   * 显示编辑资源表单页.
   *
   * @param  int $id
   *
   * @return \think\Response
   */
  public
  function edit( $id ) {

    ( new AdminMenuValidate() )->goCheck( 'edit' );

    $item = AdminMenuModel::get( $id );
    $list = AdminMenuModel::all()->toArray();

    $listToTree = Tree::instance( $list )->makeOption(0,$item['pid']);

    return $this->fetch( '',
                         [
                           'item'        => $item,
                           'option_tree' => $listToTree
                         ] );
  }

  /**
   * 保存更新的资源
   *
   * @param  \think\Request $request
   * @param  int $id
   *
   * @return \think\Response
   */
  public
  function update( Request $request, $id ) {
    ( new AdminMenuValidate() )->goCheck( 'update' );

    AdminMenuModel::update( input( 'post.' ));

    return json( [ 'error_code' => 0, 'msg' => '菜单编辑成功' ] );
  }

  /**
   * 删除指定资源
   *
   * @param  int $id
   *
   * @return \think\Response
   */
  public
  function delete( $id ) {
    return json( [ 'error_code' => 0, 'msg' => '删除成功' . $id ] );
  }


  public
  function lists() {
    $list = AdminMenuModel::all();
    $count = AdminMenuModel::count();

    return json( [ 'total' => $count, 'rows' => $list ] );
  }

  public
  function recyclebin( $id ) {
    return json( [ 'error_code' => 0, 'msg' => '放入回收站成功' . $id ] );
  }

  public
  function status( $id ) {

    return json( [ 'error_code' => 0, 'msg' => '状态修改成功' . $id ] );
  }

  public
  function order() {

  }
}
