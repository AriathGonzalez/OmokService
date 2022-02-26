<?php
include_once "MoveStrategy.php";

class SmartStrategy extends MoveStrategy{
    public function __construct(Board $board = null, $posFile = null){
        parent::__construct($board, $posFile);
    }
    
    // Opponent does Smart Strategy
    public function pickPlace(){
        $pos = json_decode(file_get_contents($this->posFile));
        $x = $pos->x; $y = $pos->y;
        $size = $this->boardSize(); $board = $this->board->places;
        
        $playerInfo = $this->board->checkPlaces($x, $y, 1, 3);
        $playerInfo = json_decode($playerInfo);
        
        // Player close to winning -> Defend
        if (property_exists($playerInfo, "dir")){
            $dir = $playerInfo->dir;
            return $this->defend($x, );
            
        }
        // Otherwise -> Attack
        else {
            return $this->attack();
        }
    } 
    
    // Will block the player from making win
    public function defend($dir, $board, $size, $x, $y){
        if ($dir == "horizontal"){
            return $this->blockHorizontal($board, $size, $x, $y);
        }
        else if ($dir == "vertical"){
            return $this->blockVertical($board, $size, $x, $y);
        }
        else if ($dir == "leftRight"){
            return $this->blockLeftRight($board, $size, $x, $y);
        }
        else{
            return $this->blockRightLeft($board, $size, $x, $y);
        }
    }
    
    // Will attack the player
    public function attack(){
        $attack = new RandomStrategy($this->board);
        return $attack->pickPlace();
    }
    
    public function blockHorizontal($board, $size, $x, $y){
        $yc = $y; 
        
        // Check left
        while ($yc - 1 > -1 and $board[$x][$yc - 1] === 1){
            $yc--;
        }
        if ($yc - 1 > -1){
            $yc--;
            if ($board[$x][$yc] === 0){
                return [$x][$yc];
            }
        }
        
        $yc = $y;   // Reset
        
        // Check right
        while ($yc + 1 < $size and $board[$x][$yc + 1] === 1){
            $yc++;
        }
        if ($yc + 1 < $size){
            $yc++;
            if ($board[$x][$yc] === 0){
                return [$x][$yc];
            }
        }
        
        // Full
        return $this->attack();
    }
    
    public function blockVertical($board, $size, $x, $y){
        $xc = $x; 
        
        // Check Up
        while ($xc - 1 > -1 and $board[$xc - 1][$yc] === 1){
            $xc--;
        }
        if ($xc - 1 > -1){
            $xc--;
            if ($board[$xc][$y] === 0){
                return [$xc][$y];
            }
        }
        
        $xc = $x;
        
        // Check Down
        while ($xc + 1 < $size and $board[$xc + 1][$yc] === 1){
            $xc++;
        }
        if ($xc + 1 < $size){
            $xc++;
            if ($board[$xc][$y] === 0){
                return [$xc][$y];
            }
        }
        
        // Full
        return $this->attack();
    }
    
    public function blockLeftRight($board, $size, $x, $y){
        $xc = $x; $yc = $y; 
        
        // Check Left/Upper
        while ($xc - 1 > -1 and $yc - 1 > -1 and $board[$xc - 1][$yc - 1] === 1){
            $xc--; $yc--;
        }
        if ($xc - 1  > -1 and $yc - 1 > -1){
            $xc--; $yc--;
            if ($board[$xc][$yc] === 0){
                return [$xc][$yc];
            }
        }
        
        $xc = $x; $yc = $y;
        
        // Check Right/Lower
        while ($xc + 1 < $size and $yc + 1 < $size and $board[$xc + 1][$yc + 1] === 1){
            $xc++; $yc++;
        }
        if ($xc + 1 < $size and $yc + 1 < $size){
            $xc++; $yc++;
            if ($board[$xc][$yc] === 0){
                return [$xc][$yc];
            }
        }
        
        // Full
        return $this->attack();
    }
    
    public function blockRightLeft($board, $size, $x, $y){
        $xc = $x; $yc = $y; 
        
        // Check Right/Upper
        while ($xc - 1 > -1 and $yc + 1 < $size and $board[$xc -1][$yc + 1] === 1){
            $xc--; $yc++;
        }
        if ($xc - 1  > -1 and $yc + 1 < $size){
            $xc--; $yc++;
            if ($board[$xc][$yc] === 0){
                return [$xc][$yc];
            }
        }
        
        $xc = $x; $yc = $y;
        
        // Check Left/Lower
        while ($xc + 1 < $size and $yc - 1 > -1 and $board[$xc + 1][$yc - 1] === 1){
            $count++;
            $xc++; $yc--;
        }
        if ($xc + 1 < $size and $yc - 1 > -1){
            $xc++; $yc--;
            if ($board[$xc][$yc] === 0){
                return [$xc][$yc];
            }
        }
        
        // Full
        return $this->attack();
    }
}
?>