

<?php
require_once 'connection.php';
$id = $_REQUEST['id'];
$responseArray = array();
$sql = "SELECT * FROM users WHERE id= $id";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_assoc($result);

$showid=$rows['id'];
$user_id = $rows['user_id'];
$user_name = $rows['user_name'];
$password = $rows['password'];
$date = $rows['date'];
$newdate = strtotime($date);
$url = "http://localhost/login/show_user.php?showid=$showid&user_id=$user_id&user_name=$user_name&password=$password&date=$newdate";

$response = file_get_contents($url);
print "<pre>";
print_r($response);
print "</pre>";
exit;

$decoded = json_decode($response,true);

$url = "http://localhost/login/show_user.php?showid=$showid&user_id=$user_id&user_name=$user_name&password=$password&date=$newdate";

$response = file_get_contents($url);

$decoded = json_decode($response);

$id = $decoded['id'];
$user_id = $decoded['user_id'];
$user_name = $decoded['user_name'];
$password = $decoded['password'];
$date = $decoded['date'];

?>

<html>
<body>
<table border='1'>
    <tr>
        <th>User_id</th>
        <th>User_name</th>
        <th>Password</th>
        <th>Date</th>
    </tr>




    <tr>
        <form method='post' action='update_user_validation.php?id=<?php echo $id ?>'>
            <td><input type='text' name='user_id' value='<?php echo $user_id ?>'/></td>
            <td><input type='text' name='user_name' value='<?php echo $user_name ?>'/></td>
            <td><input type='text' name='password' value='<?php echo $password ?>'/></td>
            <td><input type='text' name='date' value='<?php echo $date ?>'/></td>
            <td><input type='submit'/></td>
    </tr>


</table>
</body>
</html>
<?php
mysqli_close($con);
?>







