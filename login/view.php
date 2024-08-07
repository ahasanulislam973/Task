<?php
require_once 'connection.php';
$id = $_REQUEST['id'];
$responseArray = array();
/*$sql = "SELECT * FROM users WHERE id= $id";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_assoc($result);*/
$url = "http://localhost/login/show.php?id=".$id;

$response = file_get_contents($url);

$decoded = json_decode($response);

$showid=$decoded->id;
$user_id=$decoded->user_id;
$user_name=$decoded->user_name;
$password=$decoded->password;
$date=$decoded->date;

/*$showid = $rows['id'];
$user_id = $rows['user_id'];
$user_name = $rows['user_name'];
$password = $rows['password'];
$date = $rows['date'];*/
?>

<html>
<body>
<table border='1'>
    <tr>
        <th>Id</th>
        <th>User_Id</th>
        <th>User_Name</th>
        <th>Password</th>
        <th>Date</th>
    </tr>


    <tr>
        <td> <?php echo $showid ?> </td>
        <td> <?php echo $user_id ?> </td>
        <td> <?php echo $user_name ?> </td>
        <td> <?php echo $password ?> </td>
        <td> <?php echo $date ?> </td>

    </tr>


</table>
</body>
</html>
<?php
mysqli_close($con);
?>

