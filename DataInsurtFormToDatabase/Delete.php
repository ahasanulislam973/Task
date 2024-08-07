<?php
require_once 'database.php';

$sql = "DELETE FROM employees WHERE id=2"; //for multiple delete we can use where id in(id number,id number,....); & single delete we can use just where id=id number
// for delete multiple data from x to z we can use where id>from which number start from deleting.
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);