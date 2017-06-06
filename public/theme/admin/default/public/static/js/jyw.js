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
      elements: { selectors: [ ".page-content-area[data-ajax-content='true']" ] }
    }
  }
  
  var demo_ajax_options = {
    default_url: 'admin/index/welcome.html',//default hash
    loading_icon: 'fa fa-spin fa-spinner fa-2x orange',
    loading_text: '',
    loading_overlay: null,
    update_breadcrumbs: true,
    update_title: true,
    update_active: true,
    close_active: true,
    max_load_wait: 10,//单位：s
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
  
  //1、ajaxloadstart
  //2、ajaxloaddone
  //3、ajaxloadpost
  //4、ajaxloadcomplete
  //5、ajaxloaderror
  //6、ajaxloadlong
  //7、ajaxscriptsloaded
  
  //initiate ajax loading on this element( which is .page-content-area[data-ajax-content=true] in Ace's demo)
  $( ".page-content-area[data-ajax-content='false']" ).ace_ajax( demo_ajax_options )
                                                      .one( 'ajaxloaddone', function ( e ) {
                                                        window.$pageContentArea = $( ".page-content-area[data-ajax-content='true']" );
                                                      } );
  
  //if general error happens and ajax is working, let's stop loading icon & PACE
  $( window ).on( 'error.ace_ajax ajaxloaderror ajaxloadlong', function ( e ) {
    $( ".page-content-area[data-ajax-content='true']" ).each( function () {
      var $this = $( this );
      if ( $this.ace_ajax( 'working' ) ) {
        if ( window.Pace && Pace.running ) {
          Pace.stop();
        }
        $this.ace_ajax( 'stopLoading', true );
      }
    } );
    layer.open( {
      type: 0,
      icon: 5,
      content: '请求出错，错误类型：' + e.type
    } );
  } );
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
  _this.wbSelect2 = function ( selector, options ) {
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
    $( '.wb-select2' ).trigger( 'change.select2' );
    $( '.wb-bootstrap-tagsinput' ).tagsinput( 'removeAll' );
  }
  
  /*获取 bootstrapTable 表格中 已选择项的 指定 key 的值*/
  _this.getSelectedItem = function (  selector,field ) {
    /*获取表格*/
    var $table = getTable( selector );
    
    if ( $table &&  $table.data( 'bootstrap.table' )){
     
      /*数组转对象*/
      if ($.isArray(field)){
        var _field=field;
        field = {};
        $.each( _field, function ( index,item ) {
          field[ item] =true;
        });
      }
  
      if ( $.isPlainObject( field ) ) {
        var _options     = $table.bootstrapTable( 'getOptions' ) || {};
        var _selectedArr = $table.bootstrapTable( 'getSelections' ) || [];
        var _selectedLen = _selectedArr.length;
        
        console.log( _options);
        console.log( _selectedArr );
        console.log( field );
        console.log( field.length );
        
        var _fieldData = {};
        $.each( field, function ( index, item ) {
          var _key = _options[ index ];
          if ( _key ) {
            _fieldData[ _key ] = $.map( _selectedArr, function ( _item, _index ) {
              return _item[ _key ];
            } );
            if ( item === false ) {/*数组转字符串*/
              _fieldData[ _key ] = _fieldData[ _key ].join( ',' );
            }
          }
      
        } );
      }
  
      return { "btLength": _selectedLen, "btData": _fieldData };
    }
    return false;
  };
  
  /*获取主键字段*/
  _this.getPrimaryKey=function ( selector ) {
    var $table=getTable(selector);
    
    if ($table && (selector=$table.data('bootstrap.table'))){
      return selector['options']['idField'] || 'id';
    }
    
    return 'id';
  };
  
  /*获取选中项的主键值*/
  _this.getSelectedItemPK=function ( selector ) {
    var $table=getTable(selector);
    var pks=[];
    
    if ($table && $table.data('bootstrap.table')){
      var _options = $table.bootstrapTable('getOptions');
      var _selectedItemArray= $table.bootstrapTable( 'getSelections' );
      var _pk=_options['idField'] || _options['uniqueId'] || 'id';
      
      pks=$.map(_selectedItemArray,function ( item,index ) {
        return item[_pk];
      });
    }
    
    return pks;
  };
  
  /*获取 URL 地址*/
  _this.getUrl = function ( selector ) {
    /*url属性：href data-url data-href form(action)*/
    var $selector = $( selector );
    
    var _url = $selector.attr( 'href' ) || $selector.data( 'url' ) || $selector.data( 'href' ) || '';
    
    if ( _url === '' ) {
      var _form = getForm( $selector );
      _url      = _form ? _form.eq( 0 ).attr( 'action' ) : '';
    }
    
    return _url;
  };
  
  /*修复 URL 地址*/
  _this.fixUrl = function ( url, queryObject ) {
    /*URL 格式：scheme(protocol)://hostname:port/pathname?search#hash*/
    var location = [];
    var queryStr='';
    if ( $.isPlainObject( queryObject ) ) {
      queryStr    = $.param( queryObject );
      queryStr = decodeURIComponent( queryStr);
      location = url.match( /([^#\?]+)(\??[^#]*)(#?.*)/ );
      if ( location[ 2 ].length > 1 ) {
        url = location[ 1 ] + location[ 2 ] + '&' + queryStr + location[ 3 ];
      } else {
        url = location[ 1 ] + '?' + queryStr + location[ 3 ];
      }
    }
    
    return url;
    
  };
  
  /*获取表单对象*/
  _this.getForm = function ( selector ) {
    /*直接获取真实表单对象或者通过点击按钮倒推获取表单对象*/
    /*直接获取对象*/
    var $form = $( selector );
    /*如果不是表单对象，则是通过按钮点击的*/
    if ( !$form.is( 'form' ) ) {
        selector = $form.data( 'form' ) || $form.parents( '[data-form]' ).data( 'form' ) || false;
        if ( selector ) {
          $form = $( selector );
          if ( !$form.is( 'form' ) ) {
            $form = false;
          }
        }else {
          selector = $form.parents( 'form' );
          if ( selector.is( 'form' ) ) {
            $form = selector;
          } else {
            $form=false;
          }
        }
    }
    
    return $form;
  };
  
  /*获取表格对象*/
  _this.getTable = function ( selector ) {
    /*直接获取真实表格对象或者通过点击按钮倒推获取表格对象*/
    /*直接获取对象*/
    var $table = $( selector );
    /*如果不是表格对象，则通过点击按钮获取*/
    if ( !$table.is( 'table' ) ) {
        selector = $table.data( 'table' ) || $table.parents( '[data-table]' ).data( 'table' ) || false;
        if ( selector ) {
          $table = $( selector );
          if ( !$table.is( 'table' ) ) {
            $table = false;
          }
        }else{
          selector = $table.parents( 'table' );
          if ( selector.is( 'table' ) ) {
            $table = selector;
          } else {
            $table=false;
          }
        }
    }
    return $table;
  };
  
  /*打开页面*/
  _this.openUrl    = function ( url, queryObject ) {
    if ( queryObject){
      url = fixUrl( url, queryObject);
    }
    if ( url ) {
      //$pageContentArea.ace_ajax( 'loadAddr', _url );
      window.location.hash = url;
    } else {
      layer.alert( '无效地址', { icon: 0 } );
    }
  };
  /*打开对话框*/
  _this.openDialog = function ( url, queryObject ) {
    if ( queryObject ) {
      url = fixUrl( url, queryObject );
    }
    if ( url ) {
      $.ajax( url, {
        //url:url,
        type: 'get',
        async: true,
        data: [],
        processData: true,
        dataType: 'json',
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        
        complete: function ( xhr, textStatus ) {
        
        },
        success: function ( response, textStatus, xhr ) {
          // console.log( response );
          if ( response.error_code === 0 ) {
            var index = layer.open( {
              type: 1,//页面层
              skin: 'layui-layer-lan',
              scrollbar: false,
              maxmin: true,
              resize: true,
              title: response.msg,
              content: response.data
            } );
            layer.full( index );
          } else {
            layer.alert( response.msg, { icon: 5 } );
          }
        },
        error: function ( xhr, textStatus, errorThrow ) {
          layer.alert( '无效请求', { icon: 0 } );
        }
      } );
    } else {
      layer.alert( '无效地址', { icon: 0 } );
    }
  };
  /*打开模态框*/
  _this.openModal  = function ( url, queryObject ) {
    if ( queryObject ) {
      url = fixUrl( url, queryObject );
    }
    if ( url ) {
      $.ajax( url, {
        //url:url,
        type: 'get',
        async: true,
        data: [],
        processData: true,
        dataType: 'json',
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        
        complete: function ( xhr, textStatus ) {
        
        },
        success: function ( response, textStatus, xhr ) {
          // console.log( response );
          if ( response.error_code === 0 ) {
            var index = layer.open( {
              type: 1,//页面层
              skin: 'layui-layer-lan',
              scrollbar: false,
              maxmin: true,
              resize: true,
              title: response.msg,
              content: response.data
            } );
            layer.full( index );
          } else {
            layer.alert( response.msg, { icon: 5 } );
          }
        },
        error: function ( xhr, textStatus, errorThrow ) {
          layer.alert( '无效请求', { icon: 0 } );
        }
      } );
    } else {
      layer.alert( '无效地址', { icon: 0 } );
    }
  };
  
}( window, jQuery ));

/*nice validator 默认配置项*/
$( function () {
  $.validator.config( {
    debug: 0,
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
      totalField: 'total', /*服务器端分页时返回的总数键名*/
      
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
  
  /*格式化*/
  _this.wbFormatter = {
    operate: function ( value, row, index ) {
      console.log( this );
      return $( '#wb-action-formatter' ).html();
    },
    icon: function ( value, row, index ) {
      return '<i class="' + ace.icon + ' ' + value + '"></i>';
    },
    status: function ( value, row, index ) {
      if ( value == 1 ) {
        return '<a href="" role="button" class="btn btn-minier btn-warning">启用</a>';
      } else {
        return '<a href="" role="button" class="btn btn-minier btn-danger">禁用</a>';
      }
    },
    show: function ( value, row, index ) {
      if ( value == 1 ) {
        return '<a href="" role="button" class="btn btn-minier btn-warning">显示</a>';
      } else {
        return '<a href="" role="button" class="btn btn-minier btn-danger">隐藏</a>';
      }
    }
  };
  /*格式化事件*/
  _this.wbEvents = {
    operate: {
      'click .wb-btn-add-single': function ( e, value, row, index ) {
        e.preventDefault();
        console.log( $( this ).parents( 'table' ) );
      }
    }
  };
  /*事件*/
  _this.onCheck      = function ( row, $element ) {
  };
  _this.onUncheck    = function ( row, $element ) {
  };
  _this.onCheckAll   = function ( rows ) {
  };
  _this.onUncheckAll = function ( rows ) {
  };
  
})( window, jQuery );

/*ajax设置*/
$( function () {
  $.ajaxSetup( {
    global: true,
    traditional: false,
    statusCode: {
      '400':function ( xhr, statusText, errorThrow ) {
        var response = xhr.responseJSON;
        layer.alert( response.msg, { icon: 5 } );
      },
      '404': function ( xhr, statusText, errorThrow) {
        var response = xhr.responseJSON;
        layer.alert( response.msg, { icon: 5 } );
      }
    }
  } );
} );

/*事件绑定*/
$( function () {
  
  $( document ).on( 'click.wb', '.wb-btn-add-backup', function ( e ) {
    e.preventDefault();
    var _url = $( this ).attr( 'href' ) || $( this ).data( 'url' ) || $( this ).data( 'href' ) || '';
    if ( _url ) {
      $.ajax( _url, {
        //url:'',
        type: 'get',
        async: true,
        data: [],
        processData: true,
        dataType: 'json',
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        
        complete: function ( xhr, statusText ) {
        
        },
        success: function ( response, statusText, xhr ) {
          console.log( response );
          if ( response.code === 0 ) {
            var index = layer.open( {
              type: 1,//页面层
              skin: 'layui-layer-lan',
              scrollbar: false,
              maxmin: true,
              resize: true,
              title: response.data.title,
              content: response.data.html
            } );
            layer.full( index );
          } else {
            layer.open( {
              type: 0,//信息层
              icon: 5,
              content: '无效响应'
            } );
          }
        },
        error: function ( xhr, statusText, errorThrow ) {
          layer.open( {
            icon: 0,
            type: 0,
            content: '无效请求'
          } );
        }
      } );
    } else {
      layer.alert( '无效 URL', { icon: 0 } );
    }
    
  } );
  
  /*新增*/
  $( document ).on( 'click.wb', '.wb-btn-add', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      if ( $( this ).hasClass( 'wb-btn-add-dialog' ) ) {
        openDialog( _url );
      } else {
        openHash( _url );
      }
    } else {
      layer.alert( '无效地址', { icon: 0 } );
    }
  } );
  /*编辑、批量编辑*/
  $( document ).on( 'click.wb', '.wb-btn-edit', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      if ( $( this ).is( '.wb-btn-edit-dialog' ) ) {
      
      } else {
        //$pageContentArea.ace_ajax( 'loadAddr', _url );
        window.location.hash = _url;
      }
    } else {
      layer.alert( '无效地址', { icon: 0 } );
    }
  } );
  /*查看*/
  $( document ).on( 'click.wb', '.wb-btn-detail', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  
  /*放入回收站*/
  $( document ).on( 'click.wb', '.wb-btn-recyclebin', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*删除*/
  $( document ).on( 'click.wb', '.wb-btn-delete', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  
  /*排序*/
  $( document ).on( 'click.wb', '.wb-btn-order', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*全选*/
  $( document ).on( 'click.wb', '.wb-btn-checkall', function ( e ) {
    e.preventDefault();
    
    var _table = getTable( this );
    if ( _table ) {
      _table.bootstrapTable( 'checkAll' );
    } else {
      layer.alert( '无效关联', { icon: 0 } );
    }
    
  } );
  /*取消选择*/
  $( document ).on( 'click.wb', '.wb-btn-checknone', function ( e ) {
    e.preventDefault();
    
    var _table = getTable( this );
    if ( _table ) {
      _table.bootstrapTable( 'uncheckAll' );
    } else {
      layer.alert( '无效关联', { icon: 0 } );
    }
  } );
  /*反选*/
  $( document ).on( 'click.wb', '.wb-btn-checkinvert', function ( e ) {
    e.preventDefault();
    
    var _table = getTable( this );
    if ( _table ) {
      _table.bootstrapTable( 'checkInvert' );
    } else {
      layer.alert( '无效关联', { icon: 0 } );
    }
  } );
  
  /*表单验证提交*/
  $( document ).on( 'click.wb', '.wb-btn-validate-submit', function ( e ) {
    e.preventDefault();
    
    var _url  = getUrl( this );
    var _form = getForm( this );
    
    if ( _url && _form ) {
      _form.ajaxSubmit( {
        url: _url,
        type: 'post',
        dataType: 'json',
        async: true,
        data: [],
        headers: {},
        processData: true,
        /*jquery.form参数 start*/
        beforeSubmit: function ( data, form, options ) {
          return form.isValid();
        },
        // beforeSerialize:function ( form,options ) {
        //
        // },
        //clearForm: true,
        //resetForm: true,
        //target:'#id.class',
        //replaceTarget:true,
        /*jquery.form参数 end*/
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        complete: function ( xhr, statusText ) {
        
        },
        success: function ( response, statusText, xhr ) {
          if ( response.error_code === 0 ) {
            layer.alert( response.msg, { icon: 6 } );
          } else {
            layer.alert( response.msg, { icon: 5 } );
          }
        },
        error: function ( xhr, statusText, errorThrow ) {
          var response=xhr.responseJSON;
          layer.alert( response.msg, { icon: 5 } );
        }
      } );
    } else {
      layer.alert( '表单地址不存在', { icon: 0 } );
    }
  } );
  /*表单直接提交*/
  $( document ).on( 'click.wb', '.wb-btn-submit', function ( e ) {
    e.preventDefault();
    
    var _url  = getUrl( this );
    var _form = getForm( this );
    
    if ( _url && _form ) {
      _form.ajaxSubmit( {
        url: _url,
        type: 'post',
        dataType: 'json',
        async: true,
        data: [],
        processData: true,
        beforeSubmit: function ( data, form, options ) {
          console.log( data );
          console.log( form );
          console.log( options );
          
          return form.isValid();
        },
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        statusCode: {
          '404': function () {
          
          }
        },
        complete: function ( xhr, statusText ) {
        
        },
        success: function ( response, statusText, xhr ) {
          console.log( response );
          if ( response.code === 0 ) {
            var index = layer.open( {
              type: 0,//信息层
              icon: 6,
              skin: 'layui-layer-lan',
              content: response.data.username
            } );
          } else {
            layer.open( {
              type: 0,//信息层
              icon: 5,
              content: '无效响应'
            } );
          }
        },
        error: function ( xhr, statusText, errorThrow ) {
          layer.open( {
            icon: 0,
            type: 0,
            content: '无效请求'
          } );
        }
      } );
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*保存*/
  $( document ).on( 'click.wb', '.wb-btn-save', function ( e ) {
    e.preventDefault();
    
    var _url  = getUrl( this );
    var _form = getForm( this );
    
    if ( _url && _form ) {
      _form.ajaxSubmit( {
        url: _url,
        type: 'post',
        dataType: 'json',
        async: true,
        data: [],
        processData: true,
        beforeSubmit: function ( data, form, options ) {
          console.log( data );
          console.log( form );
          console.log( options );
          
          return form.isValid();
        },
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        statusCode: {
          '404': function () {
          
          }
        },
        complete: function ( xhr, statusText ) {
        
        },
        success: function ( response, statusText, xhr ) {
          console.log( response );
          if ( response.code === 0 ) {
            var index = layer.open( {
              type: 0,//信息层
              icon: 6,
              skin: 'layui-layer-lan',
              content: response.data.username
            } );
          } else {
            layer.open( {
              type: 0,//信息层
              icon: 5,
              content: '无效响应'
            } );
          }
        },
        error: function ( xhr, statusText, errorThrow ) {
          layer.open( {
            icon: 0,
            type: 0,
            content: '无效请求'
          } );
        }
      } );
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*更新*/
  $( document ).on( 'click.wb', '.wb-btn-update', function ( e ) {
    e.preventDefault();
    
    var _url  = getUrl( this );
    var _form = getForm( this );
    
    if ( _url && _form ) {
      _form.ajaxSubmit( {
        url: _url,
        type: 'post',
        dataType: 'json',
        async: true,
        data: [],
        processData: true,
        beforeSubmit: function ( data, form, options ) {
          console.log( data );
          console.log( form );
          console.log( options );
          
          return form.isValid();
        },
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        statusCode: {
          '404': function () {
          
          }
        },
        complete: function ( xhr, statusText ) {
        
        },
        success: function ( response, statusText, xhr ) {
          console.log( response );
          if ( response.code === 0 ) {
            var index = layer.open( {
              type: 0,//信息层
              icon: 6,
              skin: 'layui-layer-lan',
              content: response.data.username
            } );
          } else {
            layer.open( {
              type: 0,//信息层
              icon: 5,
              content: '无效响应'
            } );
          }
        },
        error: function ( xhr, statusText, errorThrow ) {
          layer.open( {
            icon: 0,
            type: 0,
            content: '无效请求'
          } );
        }
      } );
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*表单重置*/
  $( document ).on( 'click.wb', '.wb-btn-reset', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*从表单页返回列表页*/
  $( document ).on( 'click.wb', '.wb-btn-back-lists', function ( e ) {
    e.preventDefault();
    
    var _url = getUrl( this );
    
    if ( _url ) {
      window.location.hash = _url;
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
} );
