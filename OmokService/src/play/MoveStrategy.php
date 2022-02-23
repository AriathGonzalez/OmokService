<?php
abstract class MoveStrategy {
    protected  $board;
    
    public function __construct(Board $board = null) {
        $this->board = $board;
    }
    
    abstract function pickPlace();
    
    // JSON representation of MoveStrategy
    public function toJson (){
        return array(‘name’ => get_class($this));
    }
    
    // From JSON, returns a new MoveStrategy
    public static function fromJson() {
        $class = get_called_class();
        return new $class;
    }
    
    protected function boardSize(){
        return $this->board->size;
    }
    
    // Check if position chosen by opponent is empty
    public function checkEmpty($x, $y){
        return $this->board->places[$x][$y] !== 0 and $this->board->places[$x][$y] !== 1 ? false:true;
    }
}
?>