<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:51:"./public/theme/admin/default/admin\admin\lists.html";i:1491037424;}*/ ?>
<title>管理员列表</title>

<!-- ajax layout which only needs content area -->
<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <table id="simple-table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th class="center">
          <label class="pos-rel">
            <input type="checkbox" class="ace">
            <span class="lbl"></span>
          </label>
        </th>
        <th class="detail-col">Details</th>
        <th>Domain</th>
        <th>Price</th>
        <th class="hidden-480">Clicks</th>

        <th class="hidden-480">Status</th>

        <th>订单</th>
        <th>方法</th>
      </tr>
      </thead>

      <tbody>
      <tr>
        <td class="center">
          <label class="pos-rel">
            <input type="checkbox" class="ace">
            <span class="lbl"></span>
          </label>
        </td>

        <td class="center">
          <div class="action-buttons">
            <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
              <i class="ace-icon fa fa-angle-double-down"></i>
              <span class="sr-only">Details</span>
            </a>
          </div>
        </td>

        <td>
          <a href="#">ace.com</a>
        </td>
        <td>$45</td>
        <td class="hidden-480">3,330</td>
        <td>Feb 12</td>

        <td class="hidden-480">
          <span class="label label-sm label-warning">Expiring</span>
        </td>

        <td>
          <div class="hidden-sm hidden-xs btn-group">
            <button class="btn btn-xs btn-success" data-toggle="modal" data-target=".modal" href="<?php echo url('admin/admin/edit'); ?>">
              <i class="ace-icon fa fa-check bigger-120"></i>
            </button>

            <button class="btn btn-xs btn-info test">
              <i class="ace-icon fa fa-pencil bigger-120"></i>
            </button>

            <button class="btn btn-xs btn-danger">
              <i class="ace-icon fa fa-trash-o bigger-120"></i>
            </button>

            <button class="btn btn-xs btn-warning">
              <i class="ace-icon fa fa-flag bigger-120"></i>
            </button>
          </div>

          <div class="hidden-md hidden-lg">
            <div class="inline pos-rel">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
              </button>

              <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                <li>
                  <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
																			<span class="blue">
																				<i class="ace-icon fa fa-search-plus bigger-120"></i>
																			</span>
                  </a>
                </li>

                <li>
                  <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
																			<span class="green">
																				<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																			</span>
                  </a>
                </li>

                <li>
                  <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
																			<span class="red">
																				<i class="ace-icon fa fa-trash-o bigger-120"></i>
																			</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

<!--模态对话框-->
<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">

  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- page specific plugin scripts -->
<script type="text/javascript">
    var scripts = [null, null]
    $('.page-content-area').ace_ajax('loadScripts', scripts, function() {
        //inline scripts related to this page
      $('.modal').on('show.bs.modal',function ( e ) {
        var href=$(e.relatedTarget).attr('href');
        console.log( href);
        /*$.get( href,{},function ( data ) {
          $('.modal-dialog').html( data);
        },'json');*/

        $.get( href,{},function ( data ) {
          layer.open( { type: 1, content: data, maxmin: true} )
         /*$('.modal-dialog').html( data);*/
         },'json');

        /*$( '.modal-dialog').load( href, {}, function ( data ) {
          console.log( data );
        });*/
      });

      $( '.test' ).click( function ( e ) {
        var index = layer.open( { type: 2, content: ["<?php echo url( 'admin/Admin/test'); ?>"],maxmin:true});
      } );

    });
</script>

