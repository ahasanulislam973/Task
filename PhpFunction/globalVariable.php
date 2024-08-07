<?php
$x="hello world";

function hello(){
    global $x; // global variable
    return $x;
}

echo hello();