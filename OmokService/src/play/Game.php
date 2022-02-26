<?php
include_once "Board.php";
include_once "MoveStrategy.php";
include_once "RandomStrategy.php";
include_once "SmartStrategy.php";

class Game {
    public $board;
    public $strategy;
    public $pid;
    
    
    public function __construct($board, $strategy, $pid){
        $this->board = $board;
        $this->strategy = $strategy;
        $this->pid = $pid;
    }
    
    // JSON representation of Game
    public static function toJson($game) {
        return json_encode($game);
    }
    
    // From JSON, return a new Game
    public static function fromJson($json) {
        $obj = json_decode($json); // of stdClass
        $game = new Game(null, null, 0);
        $game->board = Board::fromJson(json_encode($obj->board));
        $game->strategy = $obj->strategy;
        return $game;
    }
    
    // Gets the last game obj put into file
    public static function saveGame($game, $file){
        file_put_contents($file, Game::toJson($game));
    }
}
?>