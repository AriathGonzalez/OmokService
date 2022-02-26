<?php
class Board {
    public $size;
    public $places;
       
    public function __construct($size){
        $this->size = $size;
        $this->places = array_fill(0, $this->size, array_fill(0, $this->size, 0));
    }
    
    // JSON representation of Board
    public static function toJson(){
        return json_encode($this);
    }
    
    // From JSON, return a new Board
    public static function fromJson($json) {
        $obj = json_decode($json); // of stdClass
        $board = new Board(0);
        $board->size = $obj->size;
        $board->places = $obj->places;
        return $board;
    }  
    
    // Check if position chosen by player is empty
    public function checkEmpty($x, $y){
        return $this->places[$x][$y] === 0 ? true:false;
    }
    
    // check if player got a Win, Draw, or nothing
    public function checkPlaces($x, $y, $player, $winCount){
        // Check horizontally
        if ($this->checkHorizontal($x, $y, $player, $winCount, $this->size, $this->places)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->places[$x], "dir" => "horizontal"));
        }
        // Check Vertically
        if ($this->checkVertical($x, $y, $player, $winCount, $this->size, $this->places)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->places[$x], "dir" => "vertical"));
        }
        // Check Left/Upper to Right/Lower
        if ($this->checkDiagnolLeft($x, $y, $player, $winCount, $this->size, $this->places)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->places[$x], "dir" => "leftRight"));
        }
        // Check Right/Upper to Left/Lower
        if ($this->checkDiagnolRight($x, $y, $player, $winCount, $this->size, $this->places)){
            return json_encode(array("x" => $x, "y" => $y, "isWin" => true, "isDraw" => false, "row" => $this->places[$x], "dir" => "rightLeft"));
        }
        // Check if Draw
        foreach ($this->places as $place){
            if (in_array(0, $place))
                return json_encode(array("x" => $x, "y" => $y, "isWin" => false, "isDraw" => false, "row" => array()));
        }
        // Draw
        return json_encode(array("x" => $x, "y" => $y, "isWin" => false, "isDraw" => true, "row" => array()));
    }
    
    public function checkHorizontal ($x, $y, $player, $winCount, $size, $board){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check left
        while ($yc - 1 > -1 and $board[$xc][$yc - 1] === $player){
            $count++;
            $yc--;
        }
        $yc = $y;   // Reset
        // Check right
        while ($yc + 1 < $size and $board[$xc][$yc + 1] === $player){
            $count++;
            $yc++;
        }
        // Check for win
        return $count >= $winCount;
    }
    
    public function checkVertical ($x, $y, $player, $winCount, $size, $board){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Up
        while ($xc - 1 > -1 and $board[$xc - 1][$yc] === $player){
            $count++;
            $xc--;
        }
        $xc = $x;
        // Check Down
        while ($xc + 1 < $size and $board[$xc + 1][$yc] === $player){
            $count++;
            $xc++;
        }
        // Check for win
        return $count >= $winCount;
    }
    
    public function checkDiagnolLeft ($x, $y, $player, $winCount, $size, $board){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Left/Upper
        while ($xc - 1 > -1 and $yc - 1 > -1 and $board[$xc - 1][$yc - 1] === $player){
            $count++;
            $xc--; $yc--;
        }
        $xc = $x; $yc = $y;
        // Check Right/Lower
        while ($xc + 1 < $size and $yc + 1 < $size and $board[$xc + 1][$yc + 1] === $player){
            $count++;
            $xc++; $yc++;
        }
        // Check for win
        return $count >= $winCount;
    }
    
    public function checkDiagnolRight ($x, $y, $player, $winCount, $size, $board){
        $xc = $x; $yc = $y; $count = 1;
        
        // Check Right/Upper
        while ($xc - 1 > -1 and $yc + 1 < $size and $board[$xc -1][$yc + 1] === $player){
            $count++;
            $xc--; $yc++;
        }
        $xc = $x; $yc = $y;
        // Check Left/Lower
        while ($xc + 1 < $size and $yc - 1 > -1 and $board[$xc + 1][$yc - 1] === $player){
            $count++;
            $xc++; $yc--;
        }
        // Check for win
        return $count >= $winCount;
    }
    
}
?>