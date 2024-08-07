<?php
require_once "./Configuration/Config.php";
function connectDB(){
    global $dbtype;
    global $server;
    global $UserId;
    global $Password;
    global $Database;

    if($dbtype== "mysqli"){
        $cn = mysqli_connect($server,$UserId, $Password, $Database);
        if(!$cn)
        {

            die("err+db connection error: " . mysqli_connect_error());
        }
        else
            return $cn;

        return $cn;
    }
}



//include "./lib/Function.php";
?>

