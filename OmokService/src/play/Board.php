<?php
class Board {
    public $size;
    public $places;
       
    public function __construct($size){
        $this->size = $size;
        $this->places = array_fill(0, 15, array_fill(0, 15, 0));
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
}

?>