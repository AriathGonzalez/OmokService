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
    
    // Check if position chosen by player is empty
    public function checkEmpty($x, $y){
        return $this->board->places[$x][$y] !== 0 ? false:true;
    }
    
    // check if player got a Win, Draw, or nothing
    public function checkPlaces($x, $y, $player){
        // Check horizontally
        if ($this->checkHorizontal($x, $y, $player)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->board->places[$x]));
        }
        // Check Vertically
        if ($this->checkVertical($x, $y, $player)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->board->places[$x]));
        }
        // Check Left/Upper to Right/Lower
        if ($this->checkDiagnolLeft($x, $y, $player)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->board->places[$x]));
        }
        // Check Right/Upper to Left/Lower
        if ($this->checkDiagnolRight($x, $y, $player)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->board->places[$x]));
        }
        // Check if Draw
        foreach ($this->board->places as $place){
            if (in_array(0, $place))
                return json_encode(array("x" => $x, "y" => $y, "isWin" => false, "isDraw" => false, "row" => array()));
        }
        // Draw
        return json_encode(array("x" => $x, "y" => $y, "isWin" => false, "isDraw" => true, "row" => array()));
    }
    
    public function checkHorizontal ($x, $y, $player){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check left
        while ($yc - 1 > -1 and $this->board->places[$xc][$yc - 1] === $player){
            $count++;
            $yc--;
        }
        $yc = $y;   // Reset
        // Check right
        while ($yc + 1 < 15 and $this->board->places[$xc][$yc + 1] === $player){
            $count++;
            $yc++;
        }
        // Check for win
        return $count === 5;
    }
    
    public function checkVertical ($x, $y, $player){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Up
        while ($xc - 1 > -1 and $this->board->places[$xc - 1][$yc] === $player){
            $count++;
            $xc--;
        }
        $xc = $x;
        // Check Down
        while ($xc + 1 < 15 and $this->board->places[$xc + 1][$yc] === $player){
            $count++;
            $xc++;
        }
        // Check for win
        return $count === 5;
    }
    
    public function checkDiagnolLeft ($x, $y, $player){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Left/Upper
        while ($xc - 1 > -1 and $yc - 1 > -1 and $this->board->places[$xc - 1][$yc - 1] === $player){
            $count++;
            $xc--; $yc--;
        }
        $xc = $x; $yc = $y;
        // Check Right/Lower
        while ($xc + 1 < 15 and $yc + 1 < 15 and $this->board->places[$xc + 1][$yc + 1] === $player){
            $count++;
            $xc++; $yc++;
        }
        // Check for win
        return $count === 5;
    }
    
    public function checkDiagnolRight ($x, $y, $player){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Right/Upper
        while ($xc -1 > -1 and $yc + 1 < 15 and $this->board->places[$xc -1][$yc + 1] === $player){
            $count++;
            $xc--; $yc++;
        }
        $xc = $x; $yc = $y;
        // Check Left/Lower
        while ($xc + 1 < 15 and $yc - 1 > -1 and $this->board->places[$xc + 1][$yc - 1] === $player){
            $count++;
            $xc++; $yc--;
        }
        // Check for win
        return $count === 5;
    }
    
    // Gets the last game obj put into file
    public static function saveGame($game, $file){
        file_put_contents($file, Game::toJson($game));
    }
}

?>