<?php

$responseArray = array();
$id=$_REQUEST['showid'] ?? "";
$user_id=$_REQUEST['user_id'] ?? "";
$user_name=$_REQUEST['user_name'] ?? "";
$password=$_REQUEST['password'] ?? "";
$date=$_REQUEST['date'] ?? "";
//$newdate1=strtotime($date);
$newdate=date('y-m-d h:i:s',$date);


$responseArray['result'] = "<html>
<body>
<table border='1'>
    <tr>
        <th>User_id</th>
        <th>User_name</th>
        <th>Password</th>
        <th>Date</th>
    </tr>



    <tr>
        <tr>
            <form method='post' action='update_user_validation.php?id=$id'>
                <td><input type='text' name='user_id' value= $user_id /></td>
                <td><input type='text' name='user_name' value= $user_name /></td>
                <td><input type='text' name='password' value= $password /></td>
                <td><input type='text' name='date' value= $newdate /></td>
                <td><input type='submit'/></td>
        </tr>

    </tr>


</table>
</body>
</html>";
echo json_encode($responseArray);
?>