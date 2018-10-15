<?php
require 'vendor/autload.php';

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$apiKey='46191302';
$apiSecret='e077924487e0175ec8d5c9344a3dd050c8120470';
$opentok = new OpenTok($apiKey, $apiSecret);

$group_num$_POST["group_num"];

$conn=pg_connect("host=ec2-23-21-147-71.compute-1.amazonaws.com dbname=dlfs3hk56lv93 user=guysuywytepygg password=cab4905d6f5fcd3034da4bee3305841803936c3953fb18f17cb8082c37a950d1");
$result=pg_query($conn,"SELECT sessionid, roomname FROM VIDEOSESSION where curplay=true");
echo $result;

while($row=pg_fetch_row($result)){
  $sessionid=$row[0];
  $roomname=$row[1];
}

echo $sessionid;

$token=$opentok->generateToken($sessionid, array(
  'role'       => Role::SUBSCRIBER,
  'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
  'data'       => 'name=Johnny'//방이름 변경
  ));

$response=array();
if(isset($sessionid)&&isset($token)){
  $response["apiKey"]=$apiKey;
  $response["sessionid"]=$sessionid;
  $response["token"]=$token;
  $response["video_name"]=$roomname;
  $response["success"]=true;
}

header('Content-Type: application/json; charset=utf8');
echo json_encode($response);
//echo json_encode(array("response"=>$response),JSON_UNESCAPED_UNICODE);

pg_close($conn);
?>
