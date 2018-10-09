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

// Create a session that attempts to use peer-to-peer streaming:
$session = $opentok->createSession();
// A session that uses the OpenTok Media Router, which is required for archiving:
$session = $opentok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));
// A session with a location hint:
$session = $opentok->createSession(array( 'location' => '192.168.123.106' ));
// An automatically archived session:
$sessionOptions = array(
    'archiveMode' => ArchiveMode::ALWAYS,
    'mediaMode' => MediaMode::ROUTED
);
$session = $opentok->createSession($sessionOptions);

// Store this sessionId in the database for later use
$sessionId = $session->getSessionId();

// Generate a Token from just a sessionId (fetched from a database)
$token = $opentok->generateToken($sessionId);
// Generate a Token by calling the method on the Session (returned from createSession)
$token = $session->generateToken();
// Set some options in a token
$token = $session->generateToken(array(
    'role'       => Role::MODERATOR,
    'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
    'data'       => 'name=Johnny'//방이름 변경
));

$response=array();
if(isset($sessionId)&&isset($token)){
  $response["apiKey"]=$apiKey;
  $response["sessionId"]=$sessionId;
  $response["token"]=$token;
}
header('Content-Type: application/json; charset=utf8');
echo json_encode($response);
?>
