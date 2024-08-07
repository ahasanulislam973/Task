<?php
require_once 'database.php';

$sql= "UPDATE bkashsmsdb SET transaction_fee='5.00' WHERE id= 19";

if(mysqli_query($conn, $sql)){
    echo "Update successfully";
}

else{
    echo "Do not update";
}
mysqli_close($conn);