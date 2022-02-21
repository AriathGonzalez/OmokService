<?php
    // Constants
    define("SIZE", 15);
    define("STRATEGIES", ["Smart", "Random"]);
    // Array of key-value pairs
    $info = array("size" => SIZE, "strategies" => STRATEGIES);
    echo json_encode($info);
?>