<?php

function create_file($filename, $userInfo)
{
//    echo $filename;
    $myfile = fopen("./logs/$filename", "a") or die("Unable to open file!"); // open a file
    $txt = $userInfo;
    fwrite($myfile, $txt);
    fclose($myfile);
}

?>

