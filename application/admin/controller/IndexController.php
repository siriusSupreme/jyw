<?php
namespace app\admin\controller;

use app\common\controller\AdminBaseController;

class IndexController extends AdminBaseController {

    public function index() {
      return $this->fetch();
    }
    public function welcome() {
      return $this->fetch();
    }
}
