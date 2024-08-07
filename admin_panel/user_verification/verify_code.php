<?php
require_once '../config/service_config.php';
require_once '../lib/functions.php';

/*
$logSeparator = "|";
date_default_timezone_set("Asia/Dhaka");
$fileName = "logs/VERIFY_EMAIL_CODE_" . (string)date("Y_m_d_A", time()) . ".txt";

$logTxt = json_encode($_REQUEST) . $logSeparator;
logWriteDeeper($fileName, $logTxt);
*/

$verifyData = (isset($_REQUEST['data']) && !empty($_REQUEST['data'])) ? $_REQUEST['data'] : "";

$warningMessages = "";
$successMessages = "";

$buttonDisable = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['verify'])) {

        $verifiedData = (isset($_REQUEST['data']) && !empty($_REQUEST['data'])) ? $_REQUEST['data'] : "";

        // check if click on the submit button
        if (!empty($verifyData)) {

            $verifiedData = base64_decode($verifiedData);
            $verifiedData = json_decode($verifiedData);
            if (!empty($verifiedData)) {
                $code = $verifiedData->code; // verification code
                $verifyEmail = $verifiedData->verifyEmail; // just checking verify email flag

                $cn = connectDB();
                if (!empty($code) && $verifyEmail == 1) {

                    // SetDBInfo($HT_Server, $HT_Database, $HT_UserID, $HT_Password, $HT_dbtype);
                    $qry = "SELECT email,status,verify_code,password_plain,fullname FROM `admin_users` WHERE verify_code='$code'";

                    $rs = Sql_exec($cn, $qry);
                    $resultArr = array();
                    if (Sql_Num_Rows($rs) > 0) {
                        $verifyResult = mysqli_fetch_object($rs);
                    }

                    if (!empty($verifyResult)) { // info found by verify code

                        $sql = "UPDATE admin_users SET status=1 WHERE verify_code='$code'";
                        $result = Sql_exec($cn, $sql);
                        if ($result > 0) {

                            $userLoginEmail = $verifyResult->email;
                            $userLoginPassword = $verifyResult->password_plain;
                            $userFullName = $verifyResult->fullname;

                            $resp = sendEmailVerificationMailToUser($userFullName, $userLoginEmail, $userLoginPassword, $loginUrl);
                            $buttonDisable = true;

                            if ($resp == 'SUCCESS') {
                                $successMessages .= $_SESSION['successMsg'] = "YOUR ARE NOW VERIFIED! PLEASE CHECK YOUR <strong> $userLoginEmail </strong> EMAIL AND FOLLOW THE INSTRUCTIONS.";
                            }

                            $_SESSION['successMsg'] = "YOUR ARE NOW VERIFIED! PLEASE CHECK YOUR <strong> $userLoginEmail </strong> EMAIL AND FOLLOW THE INSTRUCTIONS. IF YOU HAVE NOT RECEIVED ANY EMAIL PLEASE CONTACT WITH YOUR ADMINISTRATOR.";

                        } else {
                            $warningMessages .= 'VERIFICATION CODE IS INVALID';
                        }

                    } else {
                        $warningMessages .= 'VERIFICATION CODE NOT MATCHED.';
                    }

                } else {
                    $warningMessages .= 'INVALID REQUEST OR DATA IS NOT VALID';
                }

                ClosedDBConnection($cn);

            } else {
                $warningMessages .= 'INVALID REQUEST OR DATA IS NOT VALID';
            }

        } else { // data is not valid
            // exception
            $warningMessages .= "YOUR REQUESTED DATA IS NOT VALID";
        }
    }
}


function sendEmailVerificationMailToUser($userName, $loginEmail, $loginPassword, $loginUrl)
{
    $senderName = "The Himalayan Times ChatBot Admin Panel";
    $senderEmail = "noreply@thehimalayantimes.com";
    $subject = "Login Information for $senderName";

    $htmlContent = "<p>Dear " . $userName . ",</p>";
    $htmlContent .= "<p>Your email address has been successfully verified below is your login information.<br>";
    $htmlContent .= "<p>Login User : " . $loginEmail . "</p>";
    $htmlContent .= "<p>Login Password : " . $loginPassword . "</p>";
    $htmlContent .= "<p>Login URL : " . $loginUrl . "</p>";
    $htmlContent .= "<br><br> <strong>Please do not share this information with others.</strong> <br>";
    $htmlContent .= "Sincerely,<br>";
    $htmlContent .= "<strong>The Himalayan Times Team</strong>";

    if (sendEMail($loginEmail, $subject, $htmlContent, $senderEmail, $senderName)) {
        return 'SUCCESS';
    } else {
        return 'FAILED';
    }

}


?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Email Verification</title>

    <style type="text/css">

        body {
            margin-top: 20px;
        }

        .card-box .card-drop {
            color: #9a9da0;
            font-size: 20px;
            line-height: 1px;
            padding: 0px 5px;
            display: inline-block;
        }

        .text-success {
        !important;
        }

        .text-muted {
            color: #9a9da0 !important;
        }

        .logo-alt-box .logo {

        !important;

        }

        .logo-alt-box h5 {

        }


    </style>

</head>

<body>

<div class="container">
    <div style="background: #f5f5f5;padding-bottom:100px;padding-top:100px">
        <div class="row bootstrap snippets">
            <div class="col-md-4 col-md-offset-4">

                <div class="m-t-30 card-box"
                     style="margin-bottom: 20px;background-clip: padding-box;-moz-border-radius: 5px;border-radius: 5px;-webkit-border-radius: 5px;padding: 20px;background-color: #ffffff;box-shadow: 0 8px 42px 0 rgba(0, 0, 0, 0.08);">
                    <div class="text-center">
                        <h4 class="text-uppercase font-bold m-b-0">Email Verification !!</h4>
                    </div>
                    <div class="panel-body text-center">

                        <?php if (!empty($messages)) { ?>
                            <div class="alert alert-warning">
                                <strong>Warning!</strong> <br>
                                <?php echo $messages; ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($successMessages)) { ?>
                            <div class="alert alert-success">
                                <strong>Success!</strong> <br>
                                <?php echo $successMessages; ?>
                            </div>
                        <?php } ?>

                        <?php if ($buttonDisable == false) { ?>
                            <p class="text-muted font-13 m-t-20" style="color: #9a9da0">
                                Please click the below button to verify your email.
                            </p>
                            <div class="col text-center">
                                <form method="POST" action="">
                                    <input type="hidden" name="data" value="<?= $verifyData; ?>">
                                    <button type="submit" class="btn btn-warning" name="verify">Verify</button>
                                </form>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>