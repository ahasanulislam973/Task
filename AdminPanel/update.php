<?php
require_once 'database.php';
$id = $_REQUEST['id'];

$sql = "SELECT * FROM user WHERE id= $id";
$result = mysqli_query($conn, $sql);
?>

<html>
<body>
<table border='1'>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>DOB</th>
    </tr>

    <?php
    while ($rows = mysqli_fetch_assoc($result)) {

        $id = $rows['id'];
        $name = $rows['Name'];
        $email = $rows['email'];
        $phone = $rows['phone'];
        $dob = $rows['dob'];
        ?>
        <html>
        <body>
        <tr>
            <form method='post' action='updateCheck.php?id=<?php echo $id ?>'>
                <td><input type='text' name='updatename' value='<?php echo $name ?>'/></td>
                <td><input type='text' name='updateemail' value='<?php echo $email ?>'/></td>
                <td><input type='text' name='updatephone' value='<?php echo $phone ?>'/></td>
                <td><input type='text' name='updatedob' value='<?php echo $dob ?>'/></td>
                <td><input type='submit'/></td>
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
mysqli_close($conn);
?>



