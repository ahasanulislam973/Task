<?php
require_once 'database.php';

$sql = "DELETE FROM employees WHERE id in(13,14,1,5,16,17,18,19,20,21,22,23,24,25,26,27,28,29)"; //for multiple delete we can use where id in(id number,id number,....); & single delete we can use just where id=id number

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);