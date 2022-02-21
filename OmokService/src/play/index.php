<?php
include_once "Game.php";
include_once "RandomStrategy.php";
include_once "SmartStrategy.php";

define ("PID", "pid");
define ("MOVE", "move");
$response = false;

// Check for pid
if (!array_key_exists(PID, $_GET)) {   // Check if 'pid' NOT in url
    $reason = "Pid not specified";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}

// Check for move
if (!array_key_exists(MOVE, $_GET)) {   // Check if 'pid' NOT in url
    $reason = "Move not specified";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}

// Check if coordinates valid
if (strlen($_GET[MOVE]) === 0 || !strpos($_GET[MOVE], ',')){
    $reason = "Move not well-formed";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}

$uniquePlayID = $_GET[PID];
// Unknown pid
if (($data = @file_get_contents("../data/".$uniquePlayID.".txt")) === false) {
    $reason = "Unknown pid";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
} 

$loc = strpos($_GET[MOVE], ',');
$x = substr($_GET[MOVE], 0, $loc);
$y = strlen(substr($_GET[MOVE], $loc + 1)) != 0 ? substr($_GET[MOVE], $loc + 1) : 0;
// Check if valid x coordinate
if ($x < 0 || $x > 14){
    $reason = "Invalid x coordinate, $x";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}

// Check if valid y coordinate
if ($y < 0 || $y > 14){
    $reason = "Invalid y coordinate, $y";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}

// Restore the Game contents
$file = "../data/".$uniquePlayID.".txt";
$json = file_get_contents($file);
$loadedGame = Game::fromJson($json);

// Player turn
if (!$loadedGame->checkEmpty($x, $y, 1)){
    $response = false;
    $reason = "Place not empty,($x,$y)";
    echo json_encode(array("response" => $response, "reason" => $reason));
    exit;
}
$loadedGame->board->places[$x][$y] = 1;
$playerInfo = json_decode($loadedGame->checkPlaces($x, $y, 1));

// Opponent turn
if ($loadedGame->strategy->name === "Random"){
    [$opX, $opY] = RandomStrategy::doRandom($loadedGame->board->places);
    $loadedGame->board->places[$opX][$opY] = 2;
}
else {
    [$opX, $opY] = SmartStrategy::doSmart($loadedGame->board->places);
    $loadedGame->board->places[$opX][$opY] = 2;
}
$opponentInfo = json_decode($loadedGame->checkPlaces($opX, $opY, 2));

// Save Game
Game::saveGame($loadedGame, $file);

// Response 
echo json_encode(array(
    "response" => true,
    "ack_move" => $playerInfo,
    "move" => $opponentInfo,
));

?>