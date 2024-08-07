<?php
$sum = 0;
for ($a = 1; $a <= 10; $a++) {
    if ($a % 2 != 0) {

        $sum = $sum + $a;
    }

}
echo "The total odd number is:" . $sum;

