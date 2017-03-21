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
  <input type="file" name="upfiles[]" multiple><br>
  <!--多文件上传-->
  <input type="file" name="upfilec[]">
  <input type="file" name="upfilec[]"><br>

  <input type="submit" value="上传">
</form>
</body>
</html>
<?php
use vendor\Upload;

require_once __DIR__ . '/../extend/vendor/Upload.php';
if (strtolower($_SERVER['REQUEST_METHOD'])=='post'){
  $rrr=new Upload();
  $rrr->files('upfile,upfiles');

  var_dump( $_FILES);

  var_dump( '<br><br>');

  if ( $_FILES[ 'upfile' ][ 'tmp_name' ]){
    $file = new SplFileObject( $_FILES[ 'upfile' ][ 'tmp_name' ], 'r' );
    var_dump( $file->getRealPath() );
    var_dump( '<br>' );
    var_dump( $file->getPathname() );
    var_dump( '<br>' );
    var_dump( pathinfo( $_FILES[ 'upfile' ][ 'name' ]));
    var_dump( '<br>' );
    var_dump( finfo_file($finfo=finfo_open(FILEINFO_MIME_TYPE ),$_FILES[ 'upfile' ][ 'tmp_name' ] ) );
    finfo_close( $finfo);
    var_dump( '<br>' );
    var_dump( pathinfo( $_FILES[ 'upfile' ][ 'tmp_name' ],PATHINFO_EXTENSION ) );
    var_dump( '<br>' );
  }

  function test($fn){
    var_dump( $fn instanceof Closure);
  }

  test(function (){});



  var_dump( empty( [[[]],[]]));



}

?>

