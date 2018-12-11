<?php
require 'vendor/autoload.php';
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$apiKey='46191302';
$apiSecret='e077924487e0175ec8d5c9344a3dd050c8120470';

$conn=mysqli_connect("appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);

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
