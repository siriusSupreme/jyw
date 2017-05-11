/**
 * Created by Administrator on 2017/2/22.
 */

/*aja-page-content*/
$( function () {
  if ( !$.fn.ace_ajax ) {
    return;
  }
  
  if ( window.Pace ) {
    window.paceOptions = {
      ajax: true,
      document: true,
      eventLag: false, // disabled
      elements: { selectors: [ '.page-content-area' ] }
    }
  }
  
  var demo_ajax_options = {
    default_url: '/admin/index/welcome.html',//default hash
    loading_icon: 'fa fa-spin fa-spinner fa-2x orange',
    loading_text: '',
    loading_overlay: null,
    update_breadcrumbs: true,
    update_title: true,
    update_active: true,
    close_active: true,
    max_load_wait: 3000,
    close_mobile_menu: '#sidebar',
    close_dropdowns: true,
    
    'content_url': function ( hash ) {
      //***NOTE***
      //this is for Ace demo only, you should change it to return a valid URL
      //please refer to documentation for more info
      
      /*if( !hash.match(/^page\//) ) return false;
       var path = document.location.pathname;*/
      
      //for example in Ace HTML demo version we convert /ajax/index.html#page/gallery to > /ajax/content/gallery.html and load it
      /*if(path.match(/(\/ajax\/)(index\.html)?/))
       return path.replace(/(\/ajax\/)(index\.html)?/, '/ajax/content/'+hash.replace(/^page\//, '')+'.html') ;*/
      
      //for example in Ace PHP demo version we convert "ajax.php#page/dashboard" to "ajax.php?page=dashboard" and load it
      /*return path + "?" + hash.replace(/\//, "=");*/
      
      return hash;
    }
  };
  
  //for IE9 and below we exclude PACE loader (using conditional IE comments)
  //for other browsers we use the following extra ajax loader options
  if ( window.Pace ) {
    demo_ajax_options[ 'loading_overlay' ] = 'body';//the opaque overlay is applied to 'body'
  }
  
  //initiate ajax loading on this element( which is .page-content-area[data-ajax-content=true] in Ace's demo)
  $( '[data-ajax-content=false]' ).ace_ajax( demo_ajax_options )
  
  //if general error happens and ajax is working, let's stop loading icon & PACE
  $( window ).on( 'error.ace_ajax', function () {
    $( '[data-ajax-content=true]' ).each( function () {
      var $this = $( this );
      if ( $this.ace_ajax( 'working' ) ) {
        if ( window.Pace && Pace.running ) {
          Pace.stop();
        }
        $this.ace_ajax( 'stopLoading', true );
      }
    } )
  } )
} );

/*自定义函数*/
(function ( _this, $, undefined ) {
  /*输入框字数限制*/
  _this.inputMaxLengthUTF8 = function ( selector, options, callback ) {
    var defaults = {
      showOnReady: true, // true to always show when indicator is ready
      alwaysShow: true, // if true the indicator it's always shown.
      threshold: 10000, // Represents how many chars left are needed to show up the counter
      warningClass: 'label label-success',
      limitReachedClass: 'label label-important label-danger',
      separator: ' / ',
      preText: '',
      postText: '',
      showMaxLength: true,
      placement: 'bottom-right-inside',
      message: '您已输入%charsTyped%个字符，还可输入%charsRemaining%个字符，最多可输入%charsTotal%个字符。', // an alternative way to provide the message text
      showCharsTyped: true, // show the number of characters typed and not the number of characters remaining
      validate: true, // if the browser doesn't support the maxlength attribute, attempt to type more than
      // the indicated chars, will be prevented.
      utf8: true, // counts using bytesize rather than length. eg: '£' is counted as 2 characters.
      appendToParent: true, // append the indicator to the input field's parent instead of body
      twoCharLinebreak: true  // count linebreak as 2 characters to match IE/Chrome textarea validation. As well as DB storage.
    };
    if ( $.isFunction( options ) && !callback ) {
      callback = options;
      options  = {};
    }
    if ( $.isPlainObject( options ) ) {
      defaults = $.extend( defaults, options );
    }
    $( selector ).maxlength( defaults, callback );
  };
  _this.inputMaxLength     = function ( selector, options ) {
    var defaults = {
      boxAttach: false,
      boxId: 'gzc-inputlimiter',
      
      remText: '您还可以输入%n个字符，',
      remTextFilter: function ( opts, charsRemaining ) {
        var remText = opts.remText;
        if ( charsRemaining === 0 && opts.remFullText !== null ) {
          remText = opts.remFullText;
        }
        remText = remText.replace( /\%n/g, charsRemaining );
        return remText;
      },
      remTextHideOnBlur: false,
      remFullText: '输入字符已达上限，',
      
      limitTextShow: true,
      limitText: '最多可输入%n个字符。',
      limitTextFilter: function ( opts ) {
        var limitText = opts.limitText;
        limitText     = limitText.replace( /\%n/g, opts.limit );
        return limitText;
      },
      
      limitBy: 'characters',
      lineReturnCount: 1
    };
    if ( $.isPlainObject( options ) ) {
      defaults = $.extend( defaults, options );
    }
    $( selector ).inputlimiter( defaults );
  };
  /*select2*/
  _this.oSelect2 = function ( selector, options ) {
    var defaults = {
      debug: false,
      closeOnSelect: true,
      dropdownAutoWidth: true,
      minimumInputLength: 0,
      maximumInputLength: 0,
      maximumSelectionLength: 0,
      minimumResultsForSearch: 0,
      selectOnClose: true,
      sorter: function ( data ) {
        return data;
      },
      templateResult: function ( result ) {
        return result.text;
      },
      templateSelection: function ( selection ) {
        return selection.text;
      },
      theme: 'default', /*default classic*/
      width: 'resolve'
    };
    
    if ( $.isPlainObject( options ) ) {
      defaults = $.extend( defaults, options );
    }
    
    $( selector ).select2( defaults );
  }
  /*自定义重置表单*/
  _this.resetForm = function () {
    $( '.gzc-select2' ).trigger( 'change.select2' );
    $( '.gzc-bootstrap-tagsinput' ).tagsinput( 'removeAll' );
  }
  
  /*获取 bootstrapTable 表格中 已选择项的 指定 key 的值*/
  _this.getBootstrapTableField = function ( field, tableId ) {
    /*获取表格*/
    var _bootstrapTable = $( tableId || '#gzc-bootstrap-table' );
    /*获取表格选择项*/
    var _options     = _bootstrapTable.bootstrapTable( 'getOptions' );
    var _selectedArr = _bootstrapTable.bootstrapTable( 'getSelections' );
    var _selectedLen = _selectedArr.length;
    
    var _fieldData = {};
    
    if ( $.isPlainObject( field ) ) {
      $.each( field, function ( index, item ) {
        var _key = _options[ index ];
        if ( _key ) {
          _fieldData[ _key ] = $.map( _selectedArr, function ( _item, _index ) {
            return _item[ _key ];
          } );
          if ( item == false ) {/*数组转字符串*/
            _fieldData[ _key ] = _fieldData[ _key ].join( ',' );
          }
        }
        
      } );
    }
    
    return { "btLength": _selectedLen, "btData": _fieldData };
  };
}( this, jQuery ));

/*nice validator 默认配置项*/
$( function () {
  $.validator.config( {
    debug: 1,
    /*theme:'yellow_right_effect',*/
    timely: 2,
    stopOnError: false,
    focusInvalid: true,
    focusCleanup: true,
    ignore: ':hidden',
    showOk: '',
    validClass: "has-success",
    invalidClass: "has-error",
    bindClassTo: ".form-group",
    msgWrapper: 'span',
    msgStyle: 'margin-top:0;line-height:normal;',
    msgMaker: function ( options ) {
      var html;
      html = '<span role="alert" class="msg-wrap n-' + options.type + '" style="margin-left: 0;">' + options.arrow;
      if ( options.result ) {
        $.each( options.result, function ( i, obj ) {
          html += '<span class="n-' + obj.type + '">' + options.icon + '<span class="n-msg">' + obj.msg + '</span></span>';
        } );
      } else {
        html += options.icon + '<span class="n-msg">' + options.msg + '</span>';
      }
      html += '</span>';
      return html;
    },
    /*display: function ( element ) {
     return $( element ).parents( '.form-group' ).children( 'label.control-label' ).text();
     },*/
    target: function ( element ) {
      return $( element ).parents( '.form-group' ).find( '.help-block.inline' );
    }
  } );
} );


/*bootstrap-table*/
(function ( _this, $, undefined ) {
  
  /*初始化 bootstrapTable*/
  _this.initBootstrapTable = function ( selector, options ) {
    var defaults   = {
      /*表格属性*/
      classes: 'table table-hover table-condensed',
      striped: true,
      height: undefined,
      
      /*本地数据*/
      data: [],
      dataField: 'rows', /*服务器端分页时返回的数据键名*/
      totalField:'total', /*服务器端分页时返回的总数键名*/
      
      /*表格列*/
      idField: undefined, /*指定主键列*/
      minimumCountColumns: 1,
      columns: [
        /*{
         radio or checkbox
         radio: false,
         checkbox: false,
         checkboxEnabled: true,
         clickToSelect: true,
         
         列
         field: undefined,
         title: undefined,
         titleTooltip: undefined,
         
         对齐
         align: undefined, // left, right, center
         valign: undefined, // top, middle, bottom
         halign: undefined, // left, right, center
         falign: undefined, // left, right, center
         
         单元格属性
         'class': undefined,
         width: undefined,
         cellStyle: undefined,
         
         排序
         sortable: false,
         order: 'asc', // asc, desc
         sorter: undefined,
         sortName: undefined,
         
         搜索
         searchable: true,
         searchFormatter: true,
         
         显示
         visible: true,
         switchable: true,
         cardVisible: true
         
         格式化
         formatter: undefined,
         footerFormatter: undefined,
         events: undefined,
         }*/ ],
      
      /*表格行*/
      showHeader: true,
      showFooter: false,
      uniqueId: undefined, /*Indicate an unique identifier for each row.*/
      rowStyle: function ( row, index ) {
        /*row: 行数据
         index: 行下标
         返回值可以为class或者css */
        return {};
      },
      rowAttributes: function ( row, index ) {
        /*row: 行数据
         index: 行下标
         返回值可以为class或者css */
        return {};
      },
      
      /*排序*/
      sortable: true,
      sortClass: undefined,
      sortName: undefined,
      sortOrder: 'desc',
      sortStable: false,
      silentSort: true,
      customSort: $.noop,
      
      /*分页*/
      pagination: true,
      paginationLoop: true,
      onlyInfoPagination: false,
      /*客户端分页直接返回数据库查询数据；服务器端分页则返回json：{"total":100,"rows":[]}*/
      sidePagination: 'server', // client or server
      totalRows: 0, // server side need to set
      pageNumber: 1,
      pageSize: 10,
      pageList: [ 10, 25, 50, 100, 150, 200, 'ALL' ],
      paginationHAlign: 'right', //right, left
      paginationVAlign: 'bottom', //bottom, top, both
      paginationDetailHAlign: 'left', //right, left
      paginationPreText: '&lsaquo;',
      paginationNextText: '&rsaquo;',
      showPaginationSwitch: false,
      
      /*ajax 异步*/
      method: 'get',
      url: undefined,
      ajax: undefined,
      cache: true,
      contentType: 'application/json',
      dataType: 'json',
      ajaxOptions: {},
      queryParams: function ( params ) {
        /*queryParamsType = 'limit' ,返回参数必须包含
         limit, offset, search, sort, order 否则, 需要包含:
         pageSize, pageNumber, searchText, sortName, sortOrder.
         返回false将会终止请求 */
        return params;
      },
      queryParamsType: '', // '' or 'limit'
      responseHandler: function ( res ) {
        return res;
      },
      
      /*搜索*/
      search: false,
      searchOnEnterKey: false,
      strictSearch: false,
      searchAlign: 'right',
      searchTimeOut: 500,
      searchText: '',
      trimOnSearch: true,
      customSearch: $.noop,
      
      /*radio or checkbox*/
      selectItemName: 'btSelectItem',
      clickToSelect: false,
      singleSelect: false,
      checkboxHeader: true,
      maintainSelected: false,
      
      /*自定义工具条*/
      toolbar: undefined,
      toolbarAlign: 'left',
      
      /*内置工具条*/
      showColumns: true,
      showRefresh: true,
      showToggle: true,
      buttonsClass: 'primary',
      buttonsAlign: 'right',
      iconSize: 'sm',
      iconsPrefix: 'ace-icon fa', // glyphicon of fa (font awesome)
      icons: {
        paginationSwitchDown: 'fa-chevron-down',
        paginationSwitchUp: 'fa-chevron-up',
        refresh: 'fa-refresh',
        toggle: 'fa-id-card',
        columns: 'fa-th-list',
        detailOpen: 'fa-plus',
        detailClose: 'fa-minus'
      },
      
      /*view card*/
      cardView: false,
      detailView: false,
      detailFormatter: function ( index, row ) {
        return index + '===' + row;
      },
      
      /*other*/
      locale: undefined,
      smartDisplay: true,
      escape: false,
      
      undefinedText: '-',
      footerStyle: function ( row, index ) {
        return {};
      }
    };
    var extensions = {};
    defaults       = $.extend( defaults, extensions );
    if ( $.isPlainObject( options ) ) {
      defaults = $.extend( defaults, options );
    }
    $( selector ).bootstrapTable( defaults );
  };
  
  /*序号索引格式化*/
  _this.squenceIndex = function ( value, row, index ) {
    return index + 1;
  };
  /*图标格式化*/
  _this.iconFormatter = function ( value, row, index ) {
    return '<i class="' + ace.icon + ' ' + value + '"></i>';
  };
  /*显示格式化*/
  _this.showFormatter = function ( value, row, index ) {
    if ( value == 1 ) {
      return '<a href="" role="button" class="btn btn-minier btn-warning">显示</a>';
    } else {
      return '<a href="" role="button" class="btn btn-minier btn-danger">隐藏</a>';
    }
  };
  /*状态格式化*/
  _this.statusFormatter = function ( value, row, index ) {
    if ( value == 1 ) {
      return '<a href="" role="button" class="btn btn-minier btn-warning">启用</a>';
    } else {
      return '<a href="" role="button" class="btn btn-minier btn-danger">禁用</a>';
    }
  };
  /*格式化操作*/
  _this.actionFormatter = function ( value, row, index ) {
    return '<div class="btn-group btn-group-minier">' +
      '<button type="button" class="btn btn-primary dropdown-toggle gzc-custom-action" data-toggle="dropdown">Action <span class="caret no-margin-top"></span> </button>' +
      '</div>';
  };
  
})( this, jQuery );
