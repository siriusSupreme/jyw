<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:53:"./public/theme/admin/default/admin\index\welcome.html";i:1487753799;}*/ ?>
<title>Blank Page - Ace Admin</title>

<!-- ajax layout which only needs content area -->
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    天水家园网后台管理系统
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