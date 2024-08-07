<?php
$email=$_GET['email'];
$validEmail=strpos($email,"@");
if($validEmail==true){
    echo "This is a valid email";
}
else{
    echo "This is an invalid email";
}