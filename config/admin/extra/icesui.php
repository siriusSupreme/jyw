<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 19:17
 */

return [
  'title' => "IcesUi后台框架",
  'headconfig' => '',
  'footconfig' => '',
  'scripts' => [],
  'styles' => [],
  'viewReplace' => true,
  'adminUrl' => '/admin.html',
  'adminTitle' => 'Icesui',
  'logoutUrl' => './logout.html',
  'personUrl' => './person.html',
  'welcomeTitle' => '仪表盘',
  'welcomeUrl' => './welcome.html',
  'uploadPath' => ROOT_PATH . 'public' . DS . 'uploads',
  'uploadShowUrl' => '/Uploads/',
  'uploadUidName' => 'userinfo.id',
  'uploadSize' => '200000',
  'uploadFileExt' => 'jpg,jpeg,png,gif,bmp,xls,doc,xlsx,docx,ppt,pptx',
  'uploadDb' => 'uploads',
  'tableConfig' => [
    "height" => 600,//设置表格高度
    "search" => true,
    "searchPlaceHolder" => "搜索",
    "pagination" => true,
    "pageSize" => "10",
    "showRefresh" => true,
    "showColumns" => true,
    "showExport" => true,
    "idField" => "id",
    "undefinedText" => "暂无信息",
    "initSort" => "id",
    "initSortOrder" => "desc",
    "selectedShowBtns" => ["#tableDeleteBtn"],
    "PreBtnText" => "上一页",
    "NextBtnText" => "下一页",
    "clickToSelect" => true,
    "singleSelect" => false,
    "getRowsUrl" => "/manage/index/_ajaxTable.html",
    "postData" => [],
    "tableColumns" => "",
    "tableDeleteUrl" => "",
    "tableAddUrl" => "",
    "tableAddTitle" => "",
    "tableCellClick" => "",
  ],
  'formConfig' => [
  
  ]
];
