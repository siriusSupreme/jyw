<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SplFileObject</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
  <!--单文件上传-->
  <input type="file" name="upfile"><br>
  <!--多文件上传-->
  <!--<input type="file" name="upfiles" multiple><br>-->
  <!--多文件上传-->
  <!--<input type="file" name="upfilec[]">
  <input type="file" name="upfilec[]"><br>-->

  <input type="submit" value="上传">
</form>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/17
 * Time: 14:40
 */


if (strtolower($_SERVER['REQUEST_METHOD'])=='post'){
  var_dump( $_FILES);

  $file=new SplFileObject( $_FILES['upfile']['tmp_name'],'r');
  var_dump( $file->getRealPath());
  var_dump( $file->getPathname() );
}

?>

