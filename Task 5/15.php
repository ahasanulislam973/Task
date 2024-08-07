<?php
$a=$_SERVER['HTTP_USER_AGENT'];

echo "The user is:".' '.$a."<br>";
$mobile=strpos($a,"mobile");
if($mobile==true){
    echo "This is a mobile device";
}
else{
    echo "This is a desktop";
}