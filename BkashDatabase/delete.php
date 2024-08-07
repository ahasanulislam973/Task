<?php

require_once 'database.php';

$sql = "DELETE FROM bkashsmsdb WHERE id in(10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34)"; //for multiple delete we can use where id in(id number,id number,....); & single delete we can use just where id=id number

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);