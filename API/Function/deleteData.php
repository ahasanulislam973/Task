<?php

function deleteMethod(){
    require_once '../Database/database.php';

    $sql = "DELETE FROM userinfo WHERE id= 0";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
