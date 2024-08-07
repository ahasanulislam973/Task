<?php
session_start();

if(!isset($_SESSION["username"])){
    header("Location:Login.php");
}

else{
    require_once 'database.php';
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
?>

<html>
<body>

<h1>Welcome To Admin Home Page</h1> <br>

<a href='add.php'><h1>AddUser</h1></a> <br>
<h1>User details</h1> <br>

<table border='1'>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>DOB</th>
    </tr>
    <?php
    while ($rows = mysqli_fetch_assoc($result)) {
        ?>
        <html>
        <body>
        <tr>
            <td> <?php echo $rows['Name'] ?> </td>
            <td> <?php echo $rows['email'] ?> </td>
            <td> <?php echo $rows['phone'] ?> </td>
            <td> <?php echo $rows['dob'] ?> </td>
            <td><a href='update.php?id="<?php echo $rows['id'] ?>"'>Update</a></td>
            <td><a href='delete.php?id=<?php echo $rows['id'] ?>'>Delete</a></td>
        </tr>
        </body>
        </html>
        <?php
    }
    ?>
</table>
</body>
</html>

<?php
}
?>

<?php
echo "<a href='Logout.php'><h1>Logout</h1></a>";
mysqli_close($conn);
?>


