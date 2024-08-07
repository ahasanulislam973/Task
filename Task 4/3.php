<?php
$browser=$_SERVER['HTTP_USER_AGENT'];
if(strpos($browser,"Chrome"!==false)){
    echo "Chrome";
}

