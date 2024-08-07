<?php

session_start();
$useName=$_SESSION['user_name']="Leon";
$userId=$_SESSION['user_id']="1";

echo "The user name is:".' '.$useName."<br>";
echo "The user id is:".' '.$userId;

