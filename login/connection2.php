<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="payment";
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$conn){

    die("Failed to connect");
}