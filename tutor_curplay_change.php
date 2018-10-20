<?php
require 'vendor/autoload.php';
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$con=mysqli_init();
//mysqli_ssl_set($con, NULL, NULL, {ca-cert filename}, NULL, NULL);
mysqli_real_connect($con, "appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
//$con=mysqli_connect("us-cdbr-iron-east-01.cleardb.net","b5abea0f4c48d4","f97c6b56","heroku_82b359327db23c4");
mysqli_set_charset($con,"utf8");

$sessionId=$_GET["sessionId"];

$result=mysqli_query($con,"UPDATE VIDEOSESSION SET curplay=0 WHERE sessionId='$sessionId'");//현재 저장한 id

$response=array();
$response["success"]=false;

if($result){
  $response["success"]=true;
}

mysqli_close($con);

//header('Content-Type: application/json; charset=utf8');
echo json_encode($response);
?>
