<?php 
    use app\libraries\Core;
    require_once '../app/bootstrap.php';
    //Init Core Library
    $init = new Core();

    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
?>