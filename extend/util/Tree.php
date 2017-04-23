<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/4
 * Time: 20:41
 */

namespace util;


class Tree {
  /**
   * array(
   *      0 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
   *      1 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
   *      2 => array('id'=>'3','pid'=>0,'name'=>'一级栏目三'),
   *
   *      3 => array('id'=>'4','pid'=>1,'name'=>'二级栏目一'),
   *      4 => array('id'=>'5','pid'=>1,'name'=>'二级栏目二'),
   *      5 => array('id'=>'6','pid'=>2,'name'=>'二级栏目三'),
   *
   *      6 => array('id'=>'7','pid'=>4,'name'=>'三级栏目一'),
   *      7 => array('id'=>'8','pid'=>4,'name'=>'三级栏目二')
   *      )
   * 转换为：
   * array(
   *      0=>array(
   *        1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
   *        2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
   *        3 => array('id'=>'3','pid'=>0,'name'=>'一级栏目三')
   *      ),
   *      1=>array(
   *        4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目一'),
   *        5 => array('id'=>'5','pid'=>1,'name'=>'二级栏目二')
   *      ),
   *      2=>array(
   *        6 => array('id'=>'6','pid'=>2,'name'=>'二级栏目三'),
   *      ),
   *      4=>array(
   *        7 => array('id'=>'7','pid'=>4,'name'=>'三级栏目一'),
   *        8 => array('id'=>'8','pid'=>4,'name'=>'三级栏目二')
   *      )
   * )
   */
  
  private $config = array (
    /* 主键 */
    'primary_key'  => 'id',
    /* 父键 */
    'parent_key'   => 'pid',
    /* 子节点属性 */
    'children_key' => 'children',
    /* 叶子节点属性 */
    'leaf_key'     => 'is_leaf',
    /*层级属性*/
    'level_key'    => 'level',
    /* 展开属性 */
    'expand_key'   => 'is_expand',
    /* 是否展开子节点 */
    'is_expand'    => false
  );
  
  private static $treeInstance = null;
  private        $treeData     = [];
  
  /**
   * Tree constructor.
   *
   * @param array $data
   * @param array $options
   */
  protected
  function __construct ( array $data, $options = [] ) {
    /*初始化配置*/
    $this->config = array_merge ( $this->config, $options );
    /*构造数据*/
    $this->buildData ( $data );
    
  }
  
  /**
   * @param array $data
   * @param array $options
   * @param bool $overlay
   *
   * @return null|static
   */
  public static
  function instance ( array $data = [], $options = [], $overlay = false ) {
    if ( is_null ( self::$treeInstance ) || $overlay === true ) {
      self::$treeInstance = new static( $data, $options );
    }
    
    return self::$treeInstance;
  }
  
  /**
   * 构造数据
   *
   * @param $data
   */
  private
  function buildData ( $data ) {
    extract ( $this->config );
    
    foreach ( $data as $item ) {
      $id                                  = $item[ $primary_key ];
      $parent_id                           = $item[ $parent_key ];
      $this->treeData[ $parent_id ][ $id ] = $item;
    }
  }
  
  /**
   * 获取指定 id 的父节点
   *
   * @param $id
   * @param bool $onlyone
   *
   * @return array|mixed
   */
  public
  function getParent ( $id, $onlyone = true ) {
    $_id = -1;
    
    /*获取该 $id 对应的 pid*/
    foreach ( $this->treeData as $key => $value ) {
      if ( array_key_exists ( $id, $value ) ) {
        $_id = $key;
        break;
      }
    }
    
    if ( $_id !== -1 ) {
      foreach ( $this->treeData as $k => $v ) {
        if ( array_key_exists ( $_id, $v ) ) {
          if ( $onlyone === true ) {
            return $v[ $_id ];
          } else {
            return $v;
          }
        }
      }
    } else {
      return [];
    }
    
  }
  
  /**
   * 获取指定 id 的子节点
   *
   * @param $id
   *
   * @return array|mixed
   */
  public
  function getChildren ( $id ) {
    /*不存在，返回空数组*/
    if ( !isset( $this->treeData[ $id ] ) ) {
      return [];
    }
    
    return $this->treeData[ $id ];
  }
  
  /**
   * 获取指定 id 的同辈节点
   *
   * @param $id
   *
   * @return array|mixed
   */
  public
  function getSiblings ( $id ) {
    foreach ( $this->treeData as $kpid => $vitem ) {
      if ( array_key_exists ( $id, $vitem ) ) {
        return $vitem;
      }
    }
    
    return [];
  }
  
  /**
   * 获取指定 id 的父节点链接
   *
   * @param $id
   *
   * @return array
   */
  public
  function getParentUtilTop ( $id, &$returnArray = [] ) {
    
    /*获取该 $id 对应的 pid*/
    foreach ( $this->treeData as $key => $value ) {
      if ( array_key_exists ( $id, $value ) ) {
        $returnArray[] = $value[ $id ];
        $this->getParentUtilTop ( $key, $returnArray );
        break;
      }
    }
    /*反转节点顺序，使顶级节点在第一个*/
    if ( !empty( $returnArray ) ) {
      krsort ( $returnArray );
    }
    
    return $returnArray;
  }
  
  /**
   * 产生树形数据
   *
   * @param $index
   * @param string $type
   * @param int $level
   *
   * @return array
   */
  private
  function makeTreeCore ( $index, $type = 'linear', $level = 0 ) {
    $returnArray = [];
    extract ( $this->config );
    
    foreach ( $this->treeData[ $index ] as $id => $item ) {
      /*是否展开节点*/
      if ( !isset( $item[ $expand_key ] ) ) {
        $item[ $expand_key ] = $is_expand;
      }
      /*节点层级*/
      if ( !isset( $item[ $level_key ] ) ) {
        $item[ $level_key ] = $level;
      }
      
      if ( isset( $this->treeData[ $id ] ) ) {
        /*非子节点*/
        if ( !isset( $item[ $leaf_key ] ) ) {
          $item[ $leaf_key ] = false;
        }
        if ( $type == 'normal' ) {
          /*子节点*/
          $item[ $children_key ] = $this->makeTreeCore ( $id, $type, $level + 1 );
        } elseif ( $type == 'linear' ) {
          $returnArray[] = $item;
          $returnArray   = array_merge ( $returnArray, $this->makeTreeCore ( $id, $type, $level + 1 ) );
          continue;
        }
        
      } else {
        /*是子节点*/
        if ( !isset( $item[ $leaf_key ] ) ) {
          $item[ $leaf_key ] = true;
        }
      }
      $returnArray[] = $item;
    }
    
    return $returnArray;
  }
  
  /**
   * 获取指定 id 的树形结构
   *
   * @param int $id
   * @param int $level
   *
   * @return array
   */
  public
  function makeTree ( $id = 0, $level = 0 ) {
    return $this->makeTreeCore ( $id, 'normal', $level );
  }
  
  public
  function makeTreeForHtml ( $id = 0, $level = 0 ) {
    return $this->makeTreeCore ( $id, 'linear', $level );
  }
  
  private
  function has ( $sid, $id ) {
    if ( is_integer ( $sid ) ) {
      $sid = (array)$sid;
    } elseif ( is_string ( $sid ) ) {
      $sid = explode ( ',', $sid );
    }
    
    return in_array ( $id, $sid );
  }
  
  /**
   * 获取指定 id 所有后代节点的 option
   *
   * @param int $id              指定id
   * @param string $optionStr    option字符串
   * @param string|array $sid    选中 id 数组或者逗号分割的字符串
   * @param string $disabled_key 禁用字段
   * @param bool|string $adds    前缀
   * @param array $icon          前缀图标
   *
   * @return string
   */
  public
  function makeOption ( $_id = 0, $_sid = 0,
                        $optionStr = "<option value=\$id \$selected \$disabled>\$spacer\$name</option>",
                        $disabled_key = 'disabled', $_adds = true,
                        $_icon = [ 'root' => '┋', 'tree' => '┣', 'leaf' => '┗', 'nbsp' => '&nbsp;' ] ) {
    $index     = 1;
    $resultStr = '';
    $children  = $this->getChildren ( $_id );
    if ( !empty( $children ) ) {
      $total = count ( $children );
      foreach ( $children as $kid => $vitem ) {
        if ( $index == $total ) {
          $tree = $_icon['leaf'];
        } else {
          $tree = $_icon['tree'];
        }
        if ( $_adds === true ) {
          $spacer = $tree;
          $root   = $_icon['root'] . $_icon['nbsp'];
        } elseif ( $_adds === false || strpos ( $_adds, $_icon['nbsp'] ) === 0 ) {
          $spacer = ( (string)$_adds ) . $tree;
          $root   = ( (string)$_adds ) . $_icon['nbsp'] . $_icon['nbsp'] . $_icon['nbsp'];
        } else {
          $spacer = $_adds . $tree;
          $root   = $_adds . $_icon['root'] . $_icon['nbsp'];
        }
        
        $selected = $this->has ( $_sid, $kid ) ? 'selected' : '';
        @extract ( $vitem );
        $disabled = empty( $$disabled_key ) ? '' : 'disabled';
        eval( "\$nstr = \"$optionStr\";" );
        $$disabled_key = '';
        $resultStr .= $nstr;
        $resultStr .= $this->makeOption ( $kid, $_sid, $optionStr, $disabled_key, $root, $_icon );
        $index++;
      }
    }
    
    return $resultStr;
  }
  
  
  /**
   * 生成指定 id 下的所有子节点组成的菜单
   *
   * @param int $id             获取该 id 下的所有后代节点
   * @param string $main_id     菜单顶级 id
   * @param string $main_class  菜单顶级 class
   * @param string $folder_str  下拉菜单格式
   * @param string $file_str    菜单项格式
   * @param string $placeholder 预留
   * @param string $ul_class    下拉菜单样式
   * @param string $li_class    菜单项样式
   * @param string $dropdown    下拉样式
   * @param int $showlevel      需要显示的层级数
   * @param int $currentlevel   当前层级数
   * @param bool $recursion     是否是递归调用
   *
   * @return string
   */
  function makeMenu ( $id = 0, $main_id = '', $main_class = 'nav nav-list',
                      $folder_str = "<a href='#'  class='dropdown-toggle'><i class='menu-icon \$icon'></i><span class='menu-text'>\$name</span><b class='arrow fa fa-angle-down'></b></a><b class='arrow'></b>",
                      $file_str = "<a href='#\$url' data-url='\$url'><i class='menu-icon \$icon'></i>\$name</a><b class='arrow'></b>",
                      $placeholder = '<ul><li><span class="placeholder"></span></li></ul>',
                      $ul_class = "submenu", $li_class = "", $dropdown = '',
                      $showlevel = 0, $currentlevel = 1, $recursion = false ) {
    
    $returnStr = '';
    $_children = $this->getChildren ( $id );
    
    if ( !$recursion ) {
      $returnStr = <<<"RSTR"
<ul id="$main_id" class="$main_class">
RSTR;
    }
    /*mu->li.d->ulli.d*/
    foreach ( $_children as $kid => $vitem ) {
      @extract ( $vitem );
      
      if ( ( $showlevel == 0 || $showlevel > 1 ) && isset( $this->treeData[ $kid ] ) ) {
        $floder_status = " class='$dropdown $li_class' ";
      } else {
        $floder_status = " class='$li_class' ";
      }
      $returnStr .= $recursion ? "<ul class='$ul_class'><li  $floder_status id= 'menu-item-$id'>" : "<li  $floder_status   id= 'menu-item-$id'>";
      $recursion = false;
      //判断是否为终极栏目
      if ( isset( $this->treeData[ $kid ] ) ) {
        eval( "\$nstr = \"$folder_str\";" );
        $returnStr .= $nstr;
        if ( $showlevel == 0 || ( $showlevel > 0 && $showlevel > $currentlevel ) ) {
          $returnStr .= $this->makeMenu ( $kid, $main_id, $main_class, $folder_str, $file_str, $placeholder, $ul_class,
                                          $li_class, $dropdown, $showlevel, $currentlevel + 1, true );
        } elseif ( $showlevel > 0 && $showlevel == $currentlevel ) {
          $returnStr .= $placeholder;
        }
      } else {
        eval( "\$nstr = \"$file_str\";" );
        $returnStr .= $nstr;
      }
      $returnStr .= '</li>';
    }
    
    
    if ( !$recursion ) {
      $returnStr .= '</ul>';
    }
    
    return $returnStr;
  }
  
  
}

