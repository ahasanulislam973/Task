<?php

require_once 'database.php';
$id = $_REQUEST['id'];
$sql = "DELETE FROM user WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    include('AdminHomePage.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

?>