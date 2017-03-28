<?php
namespace app\admin\controller;

use app\admin\model\AdminGroupModel;
use app\admin\model\AdminModel;
use app\common\controller\AdminBaseController;
use think\Loader;

class AdminController extends AdminBaseController {
  public function index(){
    echo '111';
    $model=new AdminModel();
    $model->adminGroups();
    $model2=new AdminGroupModel();
    $model2->admins();
    var_dump( Loader::model('admin'));
  }
}
