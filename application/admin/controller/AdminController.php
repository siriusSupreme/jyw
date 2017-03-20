<?php
namespace app\admin\controller;

use app\common\controller\AdminBaseController;

class AdminController extends AdminBaseController {

  public function lists() {
    $menu=db('auth_rule')->select();
    $this->assign('menu',$menu);
    return $this->fetch();
  }

  public function add() {
    if ($this->request->isPost()){
      $res=db('admin')->insert(input('post.'));
      if ($res==1){
        $this->success('添加菜单成功',url('admin/admin/lists'));
      }else{
        $this->error('添加菜单失败',url('admin/admin/lists'));
      }
    }else{
      return $this->fetch();
    }

  }

  public function edit() {
    return $this->fetch();
  }

  public function del() {
    return $this->fetch();
  }
}
