<?php
include_once "MoveStrategy.php";

class RandomStrategy extends MoveStrategy{
    public function __construct(Board $board = null, $posFile = null){
        parent::__construct($board, $posFile);
    }
    
    // Opponent does Random Strategy
    public function pickPlace(){
        $size = $this->boardSize();
        $x = rand(0, $size -1);
        $y = rand(0, $size -1);
        while (true){
            if ($this->board->checkEmpty($x,$y)){
                return [$x,$y];
            }
            if ($x >= $size - 1){
                $x = 0;
                $y = ($y + 1) % $size - 1;
            }else{
                $x++;
            }
        }
    }
}
?>