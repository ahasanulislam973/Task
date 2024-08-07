<?php
$value=$_GET['input'];

echo $value>30? "This is greater than 30": ($value>20? "This is greater than 20":($value>10? "This is greater than 10": "Input a number atleast greater than 10!"));
