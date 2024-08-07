<?php
// $string=$_GET['input'];

//echo "The main string message is:"."<br>".$string;
function test()
{
    $string="received airtime request of tk 300.00 for 01750000327. fee tk 0.00. balance tk 140,457.60. trxid 7149856453 at 01/05/2017 15:13. wait for confirmation.";

    $newstring=explode(' ',$string);
    return $newstring;
}
function test1()
{
    $a=test();
    print_r($a);
}

test1();