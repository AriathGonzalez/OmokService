<?php

class MoveStrategy {
    public $name;
    
    public function __construct($name){
        $this->name = $name;
    }
    
    // JSON representation of MoveStrategy
    public static function toJson (){
        return json_encode($this);
    }
    
    // From JSON, returns a new MoveStrategy
    public static function fromJson($json) {
        $obj = json_decode($json); // of stdClass
        //$strategy = $obj->{'name'};
        $moveStrategy = new MoveStrategy("");
        $moveStrategy->name = $obj->name;
        return $moveStrategy;
    }
}

?>