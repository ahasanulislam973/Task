<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="login_sample_db";
$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con){

    die("Failed to connect");
}