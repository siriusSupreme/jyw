<?php
namespace app\admin\controller;


class Index extends AdminBase {

    public function index() {

      return $this->fetch();
    }
    public function welcome() {
      $this->assign( 'cache',config('cache'));
      $this->assign( 'template', config( 'template' ) );
      $this->assign( 'sssss', config( 'sssss' ) );
      return $this->fetch();
    }

    public function test(){
      return 'hello world';
    }
}
