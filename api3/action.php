<?php
$action = $_REQUEST['action'] ?? "";
$responseArray = array();
switch ($action) {

    case 'create_user':

        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])) {


            $tokenEmail = "ahasanul@gmail.com";
            $tokenPassword = "12345";

            $url = "http://pulse-adminv2.local/token.php?tokenemail=$tokenEmail&tokenpassword=$tokenPassword";
            $response = file_get_contents($url);
            $decoded = json_decode($response);
            $tokencode = $decoded->tokencode;

            if ($tokencode == 1) {

                $token = $decoded->token;

                $url = "http://pulse-adminv2.local/validation.php?token=$token";

                $response = file_get_contents($url);
                $decoded = json_decode($response);
                $Tokenvalidcode = $decoded->Tokenvalidcode;

                 if($Tokenvalidcode==30)
                 {
                     $name = $_REQUEST['name'];
                     $email = $_REQUEST['email'];
                     $password = $_REQUEST['password'];

                     $url = "http://pulse-adminv2.local/create_user.php?name=$name&email=$email&password=$password";

                     $response = file_get_contents($url);
                     $decoded = json_decode($response);

                     $code = $decoded->code;

                     if ($code == 2) {
                         $message = $decoded->message;
                         $responseArray['code'] = $code;
                         $responseArray['message'] = $message;

                     }

                     if ($code == 1) {
                         $message = $decoded->message;

                         $responseArray['code'] = $code;
                         $responseArray['message'] = $message;


                     }
                     if ($code == 21) {
                         $message = $decoded->message;
                         $responseArray['code'] = $code;
                         $responseArray['message'] = $message;

                     }

                     if ($code == 0) {
                         $message = $decoded->message;
                         $responseArray['code'] = $code;
                         $responseArray['message'] = $message;

                     }
                 }

                if($Tokenvalidcode==31)
                {
                    $Tokenvalidmessage = $decoded->Tokenvalidmessage;
                    $responseArray['Tokenvalidcode'] = $Tokenvalidcode;
                    $responseArray['Tokenvalidmessage'] = $Tokenvalidmessage;
                }

                 }



            if ($tokencode == 0) {
                $tokenmessage = $decoded->tokenmessage;
                $responseArray['tokenmessage'] = $tokenmessage;

            }

            if ($tokencode == 2) {

                $tokenmessage = $decoded->tokenmessage;
                $responseArray['tokenmessage'] = $tokenmessage;
            }

        } else {

            $responseArray['status'] = "failed";
            $responseArray['code'] = "12";
            $responseArray['message'] = "Do not set all the field!";

        }
        echo json_encode($responseArray);
        break;


    case 'show_user':

        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            $url = "http://pulse-adminv2.local/show_user.php?id=$givenId";
            $response = file_get_contents($url);
            $decoded = json_decode($response);


            $code = $decoded->code;

            if ($code == 3) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;

            }

            if ($code == 4) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;
            }

            if ($code == 6) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;
            }

        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "4";
            $responseArray['message'] = "Id not set!";
        }
        echo json_encode($responseArray);
        break;

    case 'delete_user':

        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            $url = "http://pulse-adminv2.local/delete_user.php?id=$givenId";
            $response = file_get_contents($url);
            $decoded = json_decode($response);


            $code = $decoded->code;

            if ($code == 3) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;

            }

            if ($code == 4) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;
            }

            if ($code == 7) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;
            }

            if ($code == 8) {
                $message = $decoded->message;
                $responseArray['code'] = $code;
                $responseArray['message'] = $message;
            }


        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "4";
            $responseArray['message'] = "Id not set!";
        }
        echo json_encode($responseArray);
        break;

    case 'update_user':

        if (isset($_REQUEST['id'])) {
            $givenId = $_REQUEST['id'];
            if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])) {

                $name = $_REQUEST['name'];
                $email = $_REQUEST['email'];
                $password = $_REQUEST['password'];
                $url = "http://pulse-adminv2.local/update_user.php?id=$givenId&name=$name&email=$email&password=$password";
                $response = file_get_contents($url);
                $decoded = json_decode($response);


                $code = $decoded->code;

                if ($code == 2) {
                    $message = $decoded->message;
                    $responseArray['code'] = $code;
                    $responseArray['message'] = $message;

                }
                if ($code == 4) {
                    $message = $decoded->message;
                    $responseArray['code'] = $code;
                    $responseArray['message'] = $message;
                }
                if ($code == 3) {
                    $message = $decoded->message;
                    $responseArray['code'] = $code;
                    $responseArray['message'] = $message;

                }

                if ($code == 7) {
                    $message = $decoded->message;
                    $responseArray['code'] = $code;
                    $responseArray['message'] = $message;
                }
                if ($code == 8) {
                    $message = $decoded->message;
                    $responseArray['code'] = $code;
                    $responseArray['message'] = $message;
                }

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

        echo json_encode($responseArray);
        break;

    case '':
        $responseArray['status'] = "failed";
        $responseArray['code'] = "11";
        $responseArray['message'] = "Action do not set!";

        echo json_encode($responseArray);
        break;

}

?>