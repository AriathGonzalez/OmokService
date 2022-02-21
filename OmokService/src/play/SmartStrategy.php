<?php

class SmartStrategy extends MoveStrategy {
    // Smart Strategy by Opponent
    public static function doSmart($board){
        while ($board[$x = rand(0, 14)][$y = rand(0, 14)] != 0 || $board[$x = rand(0, 14)][$y = rand(0, 14)] != 1){
            continue;
        }
        return array($x, $y);
    }
}

?>