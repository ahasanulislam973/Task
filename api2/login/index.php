<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

$sql = "SELECT * FROM users";
$result = mysqli_query($con, $sql);
?>


<!DOCTYPE html>
<html>
<head>
    <title> My website </title>
</head>
<body>
<a href="logout.php">Logout</a>
<h1> This is the index page </h1>

<br>

Hello,<?php echo $user_data['user_name']; ?>

<h1>User details</h1>

<table border='1'>
    <tr>
        <th>User_id</th>
        <th>User_name</th>
        <th>Password</th>
        <th>Date</th>
    </tr>
    <?php
    while ($rows = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td> <?php echo $rows['user_id'] ?> </td>
            <td> <?php echo $rows['user_name'] ?> </td>
            <td> <?php echo $rows['password'] ?> </td>
            <td> <?php echo $rows['date'] ?> </td>
            <td><a href='show_user.php?id=<?php echo $rows['id'] ?>'>Update</a></td>
            <td><a href='delete.php?id=<?php echo $rows['id'] ?>'>Delete</a></td>
        </tr>

        <?php
    }
    ?>
</table>
</body>
</html>