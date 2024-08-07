<?php
$year = $_GET['input'];
//$year=2000;

if ($year % 4 == 0) {
    echo "The year is a leap year";
} elseif ($year % 100 == 0) {
    echo "The year is a leap year";
} elseif ($year % 400 == 0) {
    echo "The year is a leap year";
} else {
    echo "The year is not a leap year";
}