<?php
namespace app\admin\controller;

use app\common\controller\AdminBaseController;

class IndexController extends AdminBaseController {

    public function index() {

      return $this->fetch();
    }
    public function welcome() {
      $this->assign( 'cache',config('cache'));
      $this->assign( 'template', config( 'template' ) );
      $this->assign( 'sssss', config( 'sssss' ) );
      return $this->fetch();
    }
}
