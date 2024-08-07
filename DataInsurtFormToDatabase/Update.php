<?php
require_once 'database.php';

$sql = "UPDATE employees SET phone='01309605438' WHERE id in(7,8)";

if (mysqli_query($conn, $sql)) {
    echo "Update successfully";
} else {
    echo "Do not update";
}
mysqli_close($conn);
