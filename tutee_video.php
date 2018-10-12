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

$video_no=$_POST["position"];
$group_no=$_POST["group_no"];

$conn=pg_connect("host=ec2-23-21-147-71.compute-1.amazonaws.com dbname=dlfs3hk56lv93 user=guysuywytepygg password=cab4905d6f5fcd3034da4bee3305841803936c3953fb18f17cb8082c37a950d1");
$result=pg_query($conn,"SELECT sessionid,video_name FROM VIDEOSESSION where curplay=true");
/*num=$video_no and group_no=$group_no and */
while($row=pg_fetch_row($result)){
  $sessionId=$row[0];
  $video_name=$row[1];
}

$token = $opentok->generateToken($sessionId);
/*$token = $token->generateToken(array(
    'role'       => Role::SUBSCRIBER,
    'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
    '*/

// Generate a Token by calling the method on the Session (returned from createSession)
//$token = $session->generateToken();
// Set some options in a token


$response=array();
//if(isset($sessionId)&&isset($token)){
  $response["apiKey"]=$apiKey;
  $response["sessionid"]=$sessionid;
  $response["token"]=$token;
  $response["video_name"]=$video_name;
  $response["success"]=true;
//}
echo $apiKey;
echo $sessionid;
echo $token;
echo $video_name;

pg_close($conn);

header('Content-Type: application/json; charset=utf8');
echo json_encode("response"=>$response);


?>
