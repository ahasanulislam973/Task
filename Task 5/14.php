<?php
$number1=0;
$number2=1;
$num=0;
while($num<10){
    $number3=$number1+$number2;
    echo $number3."<br>";
    $number1=$number2;
    $number2=$number3;
    $num=$num + 1;
}
