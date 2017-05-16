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
    console.log( e.type );
    layer.open( {
      type: 0,
      icon: 5,
      content: '请求出错，错误类型：' + e.type
    } );
  } );
} );

/*自定义函数*/
(function ( _this, $, undefined ) {
  /*公共变量*/
  
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
    $( '.wb-select2' ).trigger( 'change.select2' );
    $( '.wb-bootstrap-tagsinput' ).tagsinput( 'removeAll' );
  }
  
  /*获取 bootstrapTable 表格中 已选择项的 指定 key 的值*/
  _this.getBootstrapTableField = function ( field, tableId ) {
    /*获取表格*/
    var _bootstrapTable = $( tableId || '#wb-bootstrap-table' );
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
          if ( item === false ) {/*数组转字符串*/
            _fieldData[ _key ] = _fieldData[ _key ].join( ',' );
          }
        }
        
      } );
    }
    
    return { "btLength": _selectedLen, "btData": _fieldData };
  };
  
  /*获取 URL 地址*/
  _this.getUrl = function ( selector ) {
    /*url属性：href data-url data-href form(action)*/
    var $selector = $( selector );
    
    _url = $selector.attr( 'href' ) || $selector.data( 'url' ) || $selector.data( 'href' ) || '';
    
    if ( _url === '' && getForm( $selector ) ) {
      _url = getForm( $selector ).eq( 0 ).attr( 'action' );
    }
    
    return _url;
  };
  
  /*获取表单对象*/
  _this.getForm = function ( selector ) {
    /*直接获取真实表单对象或者通过点击按钮倒推获取表单对象*/
    /*直接获取对象*/
    var $selector = $( selector );
    /*如果不是表单对象，则是通过按钮点击的*/
    if ( !$selector.is( 'form' ) ) {
      if ( $selector.parents( 'form' ).get( 0 ) ) {
        $selector = $selector.parents( 'form' );
      } else {
        $selector = $selector.data( 'form' ) ? $( $selector.data( 'form' ) ) : false;
      }
    }
    
    return $selector;
  };
  
  /*获取表格对象*/
  _this.getTable = function ( selector ) {
    /*直接获取真实表格对象或者通过点击按钮倒推获取表格对象*/
    /*直接获取对象*/
    var $selector = $( selector );
    /*如果不是表格对象，则通过点击按钮获取*/
    if ( !$selector.is( 'table' ) ) {
      $selector = $selector.data( 'table' ) ? $( $selector.data( 'table' ) ) : false;
    }
    
    return $selector;
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
  
})( window, jQuery );

/*事件绑定*/
$( function () {
  
  $( document ).on( 'click.wb', '.wb-btn-add-back', function ( e ) {
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
        statusCode: {
          '404': function () {
          
          }
        },
        complete: function ( xhr, textStatus ) {
        
        },
        success: function ( response, textStatus, xhr ) {
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
        error: function ( xhr, textStatus, errorThrow ) {
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
      //$pageContentArea.ace_ajax( 'loadAddr', _url );
      window.location.hash = _url;
      /*layer.open({
       type:2,
       content:_url,
       maxmin:true,
       btn:['yes','no']
       });*/
    } else {
      layer.open( {
        type: 0,
        icon: 0,
        content: '无效地址'
      } );
    }
  } );
  /*编辑、批量编辑*/
  $( document ).on( 'click.wb', '.wb-btn-edit', function ( e ) {
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
  /*取消选择*/
  $( document ).on( 'click.wb', '.wb-btn-checknone', function ( e ) {
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
  /*反选*/
  $( document ).on( 'click.wb', '.wb-btn-checkinvert', function ( e ) {
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
        processData: true,
        /*jquery.form参数 start*/
        beforeSubmit: function ( data, form, options ) {
          console.log( data );
          console.log( form );
          console.log( options );
          
          return form.isValid();
        },
        // beforeSerialize:function ( form,options ) {
        //
        // },
        clearForm: true,
        resetForm: true,
        //target:'#id.class',
        //replaceTarget:true,
        /*jquery.form参数 end*/
        dataFilter: function ( resopnse, dataType ) {
          return resopnse;
        },
        beforeSend: function ( XMLHttpRequest ) {
        
        },
        statusCode: {
          '404': function () {
          
          }
        },
        complete: function ( xhr, textStatus ) {
        
        },
        success: function ( response, textStatus, xhr ) {
          console.log( response );
          if ( response.code === 0 ) {
            layer.open( {
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
        error: function ( xhr, textStatus, errorThrow ) {
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
        complete: function ( xhr, textStatus ) {
        
        },
        success: function ( response, textStatus, xhr ) {
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
        error: function ( xhr, textStatus, errorThrow ) {
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
