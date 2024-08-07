<?php
$count=0;
$from=$_REQUEST['from'] ?? "";
$to=$_REQUEST['to'] ?? "";
$number=$_REQUEST['number'] ?? "";

if(is_numeric($from) && is_numeric($to)) {

    for ($i = $from; $i <= $to; $i++) {
echo $i."\n";

        $l = strlen($i);
        for ($j = 0; $j <= $l; $j++) {

            $search = substr($i, $j, 1);

            if ($search == $number) {
                $count++;
            }
        }
    }
    echo "<br><br>";
    echo "Total of searching number $number is:".$count;
}
?>

