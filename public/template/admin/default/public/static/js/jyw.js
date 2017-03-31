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
      console.log( options );
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
