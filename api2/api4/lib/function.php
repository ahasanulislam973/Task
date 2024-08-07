<?php

function logWrite($filename, $logTxt)
{

    $myfile = fopen("./logs/$filename", "a") or die("Unable to open file!"); // open a file
    $txt = $logTxt;
    fwrite($myfile, $txt);
    fclose($myfile);
}

?>
