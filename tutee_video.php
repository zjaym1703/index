<?php
require 'vendor/autoload.php';
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$apiKey='46191302';
$apiSecret='e077924487e0175ec8d5c9344a3dd050c8120470';

//$con=mysqli_init();
//mysqli_ssl_set($con, NULL, NULL, {ca-cert filename}, NULL, NULL);
//mysqli_real_connect($con, "appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
//$con=mysqli_connect("us-cdbr-iron-east-01.cleardb.net","b5abea0f4c48d4","f97c6b56","heroku_82b359327db23c4");
$conn=mysqli_connect("appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
//mysqli_real_connect($conn, "appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
mysqli_set_charset($conn,"utf8");

$group_num=$_GET["group_no"];
$group_num=(int)$group_num;
//토큰생성
$opentok = new OpenTok($apiKey, $apiSecret);
$sessionId="";
$videoName="";

$state=mysqli_query($conn,"SELECT sessionId,videoName,token FROM VIDEOSESSION WHERE curplay=1 and groupNum='$group_num'");

while($row=mysqli_fetch_array($state)){
    $sessionId=$row[0];
    $videoName=$row[1];
    $token=$row[2];
}

/*
if($sessionId){
  $token=$opentok->generateToken($sessionId, array(
    'role'       => RoleConstants::PUBLISHER,
    'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
    ));
}*/


$response=array();
$response["success"]=false;

if($sessionId){
  $response["apiKey"]=$apiKey;
  $response["sessionid"]=$sessionId;
  $response["token"]=$token;
  $response["video_name"]=$videoName;
  $response["success"]=true;
}
  header('Content-Type: application/json; charset=utf8');
  echo json_encode($response);
  mysqli_close($conn);
?>
