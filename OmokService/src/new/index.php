<?php
include_once "../play/Game.php";
include_once "../play/Board.php";
include_once "../play/MoveStrategy.php";

$response = false;  // To check if request accepted or rejected
define('STRATEGY', 'strategy');  // constant
$strategies = ["Smart", "Random"];   // supported strategies

if (!array_key_exists(STRATEGY, $_GET)) {   // Check if 'strategy' NOT in url
    $reason = "Strategy not specified";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}
$strategy = $_GET[STRATEGY];

// Check if strategy does NOT exist in strategies
if (!in_array($strategy, $strategies)){
    $reason = "Unknown strategy";
    $error = array("response" => $response, "reason" => $reason);
    echo json_encode($error);
    exit;
}
// Stategy is in strategies (Request complete)
else{
    $response = true;
    $uniquePlayID = uniqid();   // Create unique playID
    $new = array("response" => $response, "pid" => $uniquePlayID);
    
    // Create new Game
    $board = new Board(15);
    $moveStrategy = new MoveStrategy($strategy);
    $game = new Game($board, $moveStrategy, $uniquePlayID);
    
    // Save Game
    $file = "../data/".$uniquePlayID.".txt";
    Game::saveGame($game, $file);
    
    echo json_encode($new);
}
?>