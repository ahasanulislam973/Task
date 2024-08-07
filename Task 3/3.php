<?php
$factorial = $_REQUEST['input'];
$b = 1;

if(strpos($factorial,".") == "" && $factorial>=0 && is_numeric($factorial)){
    for ($factorial; $factorial >= 1; $factorial--) {
        $b = $b * $factorial;

}
    echo "The factorial number is:" . ' ' . $b;
} else {
    echo "Not calculated";
}

