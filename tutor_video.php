<?php
require 'vendor/autoload.php';

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$apiKey='46191302';
$apiSecret='e077924487e0175ec8d5c9344a3dd050c8120470';
$opentok = new OpenTok($apiKey, $apiSecret);

$conn=mysqli_connect("appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
mysqli_set_charset($conn,"utf8");

$video_name=$_GET["video_name"];
$group_num=$_GET["group_no"];

$group_num=(int)$group_num;

$sessionOptions = array(
    'archiveMode' => ArchiveMode::ALWAYS,
    'mediaMode' => MediaMode::ROUTED
);
$session = $opentok->createSession($sessionOptions);
$sessionId = $session->getSessionId();

$token = $session->generateToken(array(
    'role'       => RoleConstants::PUBLISHER,
    'expireTime' => time()+(7 * 24 * 60 * 60) // in one week
));

$arcivedId="";
$curplay=1;//현재 진행중
$response= array();

$statement = mysqli_query($conn, "INSERT INTO VIDEOSESSION (sessionId,videoName,curplay,archiveId,groupNum,token) 
VALUES('$sessionId','$video_name','$curplay','$archiveId','$group_num','$token')");
if($statement){
  $response["success"]=true;
}

$response["apiKey"]=$apiKey;
$response["sessionId"]=$sessionId;
$response["token"]=$token;

echo json_encode($response);
mysqli_close($conn);
?>
