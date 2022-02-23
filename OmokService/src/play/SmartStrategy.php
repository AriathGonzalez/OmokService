<?php
include_once "MoveStrategy.php";

class SmartStrategy extends MoveStrategy{
    public function __construct(Board $board = null){
        parent::__construct($board);
    }
    
    public function pickPlace(){
        $size = $this->boardSize();
        $x = rand(0, $size -1);
        $y = rand(0, $size -1);
        while (true){
            if (!$this->checkEmpty($x,$y)){
                return [$x,$y];
            }
            if ($x >= $size -1 ){
                $x = 0;
                $y = ($y + 1) % $size - 1;
            }else{
                $x++;
            }
        }
    } 
}
?>