
<?php
$responseArray = array();
require_once 'connection.php';
$id = $_REQUEST['id'];

$sql = "SELECT * FROM users WHERE id= $id";
$result = mysqli_query($con, $sql);
$newResult = mysqli_fetch_assoc($result);

$responseArray['result'] = $newResult;
echo json_encode($responseArray);
mysqli_close($con);
?>





