<?php
require 'vendor/autoload.php';

$conn=pg_connect("host=ec2-23-21-147-71.compute-1.amazonaws.com dbname=dlfs3hk56lv93 user=guysuywytepygg password=cab4905d6f5fcd3034da4bee3305841803936c3953fb18f17cb8082c37a950d1");
pg_set_client_encoding($conn, "UTF8");

$sessionId=$_POST["sessionId"];

$result=pg_query($conn,"UPDATE VIDEOSESSION SET curplay=false WHERE sessionId='$sessionId'");

if($result){
  $response=array();
  $response["success"]=true;
}

pg_close($conn);

header('Content-Type: application/json; charset=utf8');
echo json_encode($response);
?>
