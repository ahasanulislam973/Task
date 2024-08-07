<?php
require_once 'create_user.php';
require_once 'show_user.php';
require_once 'delete_user.php';
require_once 'update_user.php';

//$request=$_SERVER['REQUEST_METHOD'];
$responseArray = array();
if (isset($_REQUEST['create_user']) || isset($_REQUEST['show_user']) || isset($_REQUEST['delete_user']) || isset($_REQUEST['update_user'])) {

    if (isset($_REQUEST['create_user'])) {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])) {

            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
//            create_user($name, $email, $password);
//            include 'create_user.php';
            echo $url = "http://api2.test/create_user.php?name=$name&email=$email&password=$password";
            $response = file_get_contents($url);

            echo $response;


            exit;

        } else {

            $responseArray['status'] = "failed";
            $responseArray['code'] = "12";
            $responseArray['message'] = "Do not set all the field!";
        }

    }

    if (isset($_REQUEST['show_user'])) {

        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            show_user($givenId);

        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "4";
            $responseArray['message'] = "Id not set!";
        }
    }

    if (isset($_REQUEST['delete_user'])) {

        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            delete_user($givenId);

        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "4";
            $responseArray['message'] = "Id not set!";
        }
    }


    if (isset($_REQUEST['update_user'])) {
        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])) {

                $name = $_REQUEST['name'];
                $email = $_REQUEST['email'];
                $password = $_REQUEST['password'];
                update_user($givenId, $name, $email, $password);
            } else {
                $responseArray['status'] = "failed";
                $responseArray['code'] = "9";
                $responseArray['message'] = "Fillup all the field for update!";
            }


        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "4";
            $responseArray['message'] = "Id not set!";
        }
    }

} else {
    $responseArray['status'] = "failed";
    $responseArray['code'] = "11";
    $responseArray['message'] = "Action do not set!";
}

//echo json_encode($responseArray);

?>