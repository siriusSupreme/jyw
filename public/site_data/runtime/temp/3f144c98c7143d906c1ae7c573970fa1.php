<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:49:"./public/theme/admin/default/admin\admin\add.html";i:1491554331;}*/ ?>
<title>添加管理员</title>


<!-- ajax layout which only needs content area -->
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form action="<?php echo url('admin/admin/add'); ?>" class="form-horizontal" role="form" method="post" >
      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top" > <span class="red">*</span> 用户名 </label>
        <div class="col-xs-12 col-sm-5">
          <input type="text" placeholder="用户名" name="username" data-rule="required" data-tip="用户名必填，中英文均可" class="form-control input-sm">
        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom ">  </div>
      </div>

      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top" > <span class="red">*</span> 密码 </label>
        <div class="col-xs-12 col-sm-5">
          <input type="password" placeholder="密码长度在6~18位" name="password" data-rule="密码:required;length(6~18)" data-tip="密码长度在6~18位,英文、数字、_等合法字符" class="form-control input-sm">
        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom ">  </div>
      </div>

      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top" > <span class="red">*</span> 确认密码 </label>
        <div class="col-xs-12 col-sm-5">
          <input type="password" placeholder="请和第一次输入密码保持一致" name="repassword" data-rule="确认密码:required;length(6~18);match(password)" data-tip="请和第一次输入密码保持一致" data-msg="两次输入密码不一致" class="form-control input-sm">
        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom ">  </div>
      </div>

      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top"> <span class="red">*</span> 手机号：
        </label>
        <div class="col-xs-12 col-sm-5">
          <div class="input-group">
            <div class="input-group-addon"><i class="ace-icon fa fa-phone"></i></div>
            <input type="text" placeholder="手机号" name="telephone" data-rule="required" data-tip="用户名必填，中英文均可"
                   class="form-control input-sm">
          </div>

        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom "></div>
      </div>

      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top"> <span class="red">*</span> 邮箱：
        </label>
        <div class="col-xs-12 col-sm-5">
          <div class="input-group">
            <div class="input-group-addon"><i class="ace-icon fa fa-envelope"></i></div>
            <input type="text" placeholder="邮箱" name="username" data-rule="required"
                   data-tip="邮箱必填"
                   class="form-control input-sm">
          </div>
        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom "></div>
      </div>

      <div class="form-group">
        <label class="col-xs-12 col-sm-2 control-label no-padding-right padding-xs-top"> 头像：
        </label>
        <div class="col-xs-12 col-sm-5">
          <input type="hidden" name="old_avatar" value="" class="form-control input-sm">
          <input type="hidden" name="new_avatar" value="" class="form-control input-sm">
          <span class="form-control-static margin-md" ><img src="__ADMIN_STATIC__/assets/avatars/avatar.png" alt="" width="100" height="100"></span>
          <button class="btn btn-corner btn-success btn-sm" type="button" href="ff">重新上传</button>
          <button class="btn btn-corner btn-danger btn-sm" type="button">撤销上传</button>
        </div>
        <div class="help-block inline col-xs-12 col-sm-reset margin-xs-bottom "></div>
      </div>


      <div class="clearfix form-actions align-center">
        <a class="btn btn-info margin-sm-right margin-xs-vertical gzc-btn-save" role="button"
           href="<?php echo url('admin/Menu/save'); ?>">
          <i class="ace-icon fa fa-check bigger-110"></i>
          提交保存
        </a>
        <a class="btn btn-danger margin-sm-right margin-xs-vertical gzc-btn-reset" role="button">
          <i class="ace-icon fa fa-undo bigger-110"></i>
          重置表单
        </a>
        <a class="btn btn-success margin-xs-vertical gzc-btn-back-lists" role="button"
           href="<?php echo url('admin/Menu/lists'); ?>">
          <i class="ace-icon fa fa-list bigger-110"></i>
          返回列表
        </a>
      </div>

    </form >
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
    });
</script>
