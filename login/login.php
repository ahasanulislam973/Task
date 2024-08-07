<?php

session_start();
include("connection.php");
include("functions.php");
if(isset($_SESSION['user_id']))
{
    header("Location:index.php");
}
    else{
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //something was posted
            $user_name = $_POST['user_name'];
            $password = $_POST['password'];

            if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
//read from database

                $query = "select *from users where user_name='$user_name'limit 1";
                $result = mysqli_query($con, $query);
                if ($result) {
                    if ($result && mysqli_num_rows($result) > 0) {

                        $user_data = mysqli_fetch_assoc($result);
                        if ($user_data['password'] == $password) {

                            $_SESSION['user_id'] = $user_data['user_id'];
                            $role=$user_data['role'];
                            $mobile_number=$user_data['mobile_number'];
                            header("Location:index.php?role=$role&mobile_number=$mobile_number");
                            die;

                        }
                    }
                }
                echo "wrong username or password!";
            } else {
                echo "Fillup all the field";
            }
        }
    }



?>


<!DOCTYPE html>
<html>
<head>
    <title> Login </title>
</head>
<body>
<style type="text/css">

    #text {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin #aaa;
        width: 100%;

    }

    #button {
        padding: 10px;
        width: 100px;
        color: white;
        background-color: Lightblue;
        border: none;
    }

    #box {

        background-color: gray;
        margin: auto;
        width: 300px;
        padding: 20px;


    }
</style>
<div id="box">

    <form method="post">
        <div style="font-size:20px; margin: 10px; color: white;">Login</div>
        <input id="text" type="text" name="user_name" placeholder="user_name"> <br><br>
        <input id="text" type="password" name="password" placeholder="password"><br><br>
        <input id="button" type="submit" value="Login"><br><br>

        <a href="signup.php">Click to Signup</a><br><br>
    </form>

</div>

</body>
</html>
