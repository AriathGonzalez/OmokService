<?php
abstract class MoveStrategy {
    protected  $board;
    public $posFile;
    
    public function __construct(Board $board = null, $posFile = null) {
        $this->board = $board;
        $this->posFile = $posFile;
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
}
?>