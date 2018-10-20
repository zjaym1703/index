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

//$conn=mysqli_init();
//mysqli_ssl_set($con, NULL, NULL, {ca-cert filename}, NULL, NULL);
//mysqli_real_connect($conn, "appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
$conn=mysqli_connect("appmeet.mysql.database.azure.com", "myadmin@appmeet", "meet2017157920173861!","appmeet", 3306);
mysqli_set_charset($conn,"utf8");

$video_name=$_GET["video_name"];//fragment 액티비티에서 넘어오는 값
$group_num=($_GET["group_no"];//마찬가지

$group_num=(int)$group_num;
//if(isset($video_name)&& isset($group_num)){
//    echo 'isset o';
//}else {
//  echo 'isset x';
//}

// Create a session that attempts to use peer-to-peer streaming:
//$session = $opentok->createSession();
// A session that uses the OpenTok Media Router, which is required for archiving:
//$session = $opentok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));
//위치 힌트로 사용되는 IPv4 주소입니다. (기본값 : "")
//$session = $opentok->createSession(array( 'location' => '192.168.123.106' ));
//세션이 자동으로 아카이브
//$sessionOptions = array(
//    'archiveMode' => ArchiveMode::ALWAYS,
 //   'mediaMode' => MediaMode::ROUTED
//);
//$session = $opentok->createSession($sessionOptions);

// Store this sessionId in the database for later use
//$sessionId = $session->getSessionId();


//18.10.21 추가
$session = $opentok->createSession(array('mediaMode' => MediaMode::ROUTED));
//$SessionOption 대신 mediaMode만 설정
// Store this sessionId in the database for later use
$sessionId = $session->getSessionId();

//디비연결

// Generate a Token from just a sessionId (fetched from a database)
//$token = $opentok->generateToken($sessionId);
// Generate a Token by calling the method on the Session (returned from createSession)
//$token = $session->generateToken();
// Set some options in a token
$token = $session->generateToken(array(
    'role'       => Role::PUBLISHER,
    'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
    'data'       => 'name=Johnny'//방이름 변경
));

//$conn=pg_connect(getenv("postgres://guysuywytepygg:cab4905d6f5fcd3034da4bee3305841803936c3953fb18f17cb8082c37a950d1@ec2-23-21-147-71.compute-1.amazonaws.com:5432/dlfs3hk56lv93"));


/*$stat = pg_connection_status($conn);
  if ($stat === PGSQL_CONNECTION_OK) {
      echo 'Connection status ok';
  } else {
      echo 'Connection status bad';
  }*/
//pg_query($conn,"INSERT INTO VIDEOSESSION(sessionId,roomname,curplay,group_num) VALUES('$sessionId','$video_name',true,'$group_num')");
//group_num추가 --> 테이블 구조도 변경함

//$response=array();
//if(isset($sessionId)&&isset($token)){
//  $response["apiKey"]=$apiKey;
//  $response["sessionId"]=$sessionId;
//  $response["token"]=$token;
//}

//세션의 아카이브를 만듦
/*
//사용자 정의 옵션 사용해 아카이브 만들기
$archiveOptions = array(
    'name' => 'Important Presentation',     // default: null
    'hasAudio' => true,                     // default: true
    'hasVideo' => true,                     // default: true
    'outputMode' => OutputMode::COMPOSED,   // default: OutputMode::COMPOSED
    'resolution' => '1280x720'              // default: '640x480'
);

$archive = $opentok->startArchive($sessionId, $archiveOptions);

// archiveId 디비에 저장
$archiveId = $archive->id;*/

$archiveId="test";
$curplay=1;//현재 진행중
$response= array();

$statement = mysqli_query($conn, "INSERT INTO VIDEOSESSION (sessionId,videoName,curplay,archiveId,groupNum) VALUES('$sessionId','$video_name','$curplay','$archiveId','$group_num')");
if($statement){
  $response["success"]=true;
}

$response["apiKey"]=$apiKey;
$response["sessionId"]=$sessionId;
$response["token"]=$token;

echo json_encode($response);
mysqli_close($conn);
?>
