<?php
$str1 = "123";
$str2 = "008";
$str3 = "00007-STR";

$newString1 = is_int($str1);
if ($newString1) {
    echo "Str1 is an intiger" . "<br>";
} else {
    echo "Str1 is a string" . "<br>";
}
$newString2 = is_int($str2);
if ($newString2) {
    echo "Str2 is an intiger" . "<br>";
} else {
    echo "Str2 is a string" . "<br>";
}
$newString3 = is_int($str3);
if ($newString3 == true) {
    echo "Str3 is an intiger" . "<br>";
} else {
    echo "Str3 is a string" . "<br>";
}
