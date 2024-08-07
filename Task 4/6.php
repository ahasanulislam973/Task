<?php

$email=$_GET['email'];

function validEmail($email){
    return(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email));
}
if(validEmail($email)==true){
    echo "This is a Valid email";
}
else{
    echo "This is an invalid email";
}

?>
