<?php
require 'vendor/autoload.php';
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

$apiKey='46191302';
$apiSecret='e077924487e0175ec8d5c9344a3dd050c8120470';

$con=mysqli_connect("us-cdbr-iron-east-01.cleardb.net","b5abea0f4c48d4","f97c6b56","heroku_82b359327db23c4");
mysqli_set_charset($con,"utf8");

$group_num=(int)$_POST["group_no"];
//토큰생성
$opentok = new OpenTok($apiKey, $apiSecret);

$state=mysqli_query($con,"SELECT sessionId,roomName FROM VIDEOSESSION WHERE curplay=1 and group_no='$group_num'");

while($row=mysqli_fetch_row($state)){
  $sessionId=$row[0];
  $roomName=$row[1];
}
//echo $sessionId;

$token=$opentok->generateToken($sessionId, array(
  'role'       => Role::SUBSCRIBER,
  'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
  'data'       => 'name=Johnny'//방이름 변경
  ));

$response=array();
if(isset($sessionId)&&isset($token)){
  $response["apiKey"]=$apiKey;
  $response["sessionid"]=$sessionId;
  $response["token"]=$token;
  $response["video_name"]=$roomName;
  $response["success"]=true;
}
  header('Content-Type: application/json; charset=utf8');
  echo json_encode(array("response"=>$response),JSON_UNESCAPED_UNICODE);
  mysqli_close($con);

?>
