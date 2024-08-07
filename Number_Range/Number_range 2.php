<?php
$from=$_REQUEST['from'] ?? "";
$to=$_REQUEST['to'] ?? "";


function number($from,$to)
{
    if($from<=$to)
    {
        echo $from;
        number($from+1,$to);
    }

}

number($from,$to);

