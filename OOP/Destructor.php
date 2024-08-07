<?php
class flower{
    public $name;
    public $color;

    function __construct($name){
        $this->name=$name;
    }

    function __destruct()
    {
        echo $this->name;
    }
}

$obj=new flower("rose");
