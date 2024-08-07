<?php
$string="Hello";
$search=substr($string,0,1);

if($search!=false){
//$newstring=preg_replace($search)
    $newVariable="<h1><span style='background-color:blue;'>$search</span>ello World</h1>";
}
echo $newVariable;