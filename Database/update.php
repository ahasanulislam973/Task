<?php
require_once 'database.php';

$sql = "UPDATE employees SET phone='01991248551' WHERE id= 4";

if (mysqli_query($conn, $sql)) {
    echo "Update successfully";
} else {
    echo "Do not update";
}
mysqli_close($conn);