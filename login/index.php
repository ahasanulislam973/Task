<?php
session_start();
include("connection.php");
include("functions.php");
$role = $_REQUEST['role'] ?? "";
$mobile_number = $_REQUEST['mobile_number'] ?? "";
$user_data = check_login($con);

if ($mobile_number != $user_data['mobile_number']) {
    echo "This number is not registered";
} else {

    $sql = "SELECT * FROM users";
    $result = mysqli_query($con, $sql);
    ?>


    <!DOCTYPE html>
    <html>
    <head>
        <title> My website </title>
    </head>
    <body>
    <a href="logout.php">Logout</a><br><br>


    <h1> This is the index page </h1>

    <br>

    Hello,<?php echo $user_data['user_name']; ?><br><br>
    <?php
    if ($role == "admin")
    {
    ?>
    <a href="subscriber_details.php">Menu</a>
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
                <td> <?php echo date('y-m-d h:i:s', strtotime($rows['date'])) ?> </td>
                <td><a href='show.php?id=<?php echo $rows['id'] ?>'>show</a></td>
                <td><a href='view.php?id=<?php echo $rows['id'] ?>'>shownew</a></td>
                <td><a href='delete.php?id=<?php echo $rows['id'] ?>'>Delete</a></td>
                <td><a href='form.php?id=<?php echo $rows['id'] ?>'>payment</a></td>
            </tr>

            <?php
        }
        }
        else {
            ?>
            <a href="subscriber_details.php?mobile_number=<?php echo $mobile_number ?>">Menu</a>
            <?php
        }
        ?>
    </table>
    </body>
    </html>

    <?php
}
?>