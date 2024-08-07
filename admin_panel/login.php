<?php
session_start();
ob_start();
require_once './config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

if (checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $dashboardUrl);
    exit;
}

// $actionName = "authenticate.php";
$dashboardUrl = baseUrl('index.php');
$pageTitle = 'Admin User Login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $remember = filter_input(INPUT_POST, 'remember');

    $errorMsg = null;
    if (empty($username)) {
        $errorMsg .= "<p>Username/Email required</p>";
    }

    if (empty($password)) {
        $errorMsg .= "<p>Password required</p>";
    }

    $postData = array(
        'username' => $username,
        'password' => $password,
    );

    if (null == $errorMsg) {

        if (!empty($postData)) {

            $username = $postData['username'];
            $password = $postData['password'];

            // get the dta from database using username
            $dbResult = getUserInfoByUserName($username);

            // get the value from post
            $data['username'] = $username;
            $data['password'] = $password;

            // check if any data found or not
            if (!empty($dbResult)) {
                $givenPassword = md5($password);

                if ($givenPassword == $dbResult->password) {

                    if ($dbResult->status == 1) {

                        // set the login data to the session
                        $userSessionData = array(
                            'user_logged_in' => TRUE,
                            'user_id' => $dbResult->user_id,
                            'organization_id' => $dbResult->organization_id,
                            'role_id' => $dbResult->role_id,
                            'email' => $dbResult->email,
                            'fullname' => $dbResult->fullname,
                            'username' => $dbResult->username,
                            'phone' => $dbResult->phone,
                        );


                        $_SESSION['admin_login_info'] = $userSessionData;

                        // update the login information to the database
                        $updateData['lastlogin_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
                        $updateData['lastlogin_date'] = time();

                        // set the successfull message
                        $_SESSION['successMsg'] = LOGIN_SUCCESS;
                        // return to the continue URL

                        if ($_SESSION['continue']) {
                            header('Location: ' . $_SESSION['continue']);
                            exit;
                        } else {
                            // var_dump(header('Location: ' . $dashboardUrl)); exit;
                            header('Location: ' . $dashboardUrl);
                            exit;
                        }
                    } else {
                        $_SESSION['login_failure'] = "<p>You are not verified. Please verify your account then try login again!</p>";
                    }


                } else {
                    $_SESSION['login_failure'] = "<p>Your Password is incorrect.</p>";
                }
            } else {
                $_SESSION['login_failure'] = "<p>Login username/email is incorrect.</p>";
            }

        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Moon">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="<?php echo baseUrl('assets/img/favicon.png'); ?>">

    <title><?php echo isset($pageTitle) ? $pageTitle : "User Admin Login"; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo baseUrl('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo baseUrl('assets/css/bootstrap-reset.css'); ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo baseUrl('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="<?php echo baseUrl('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo baseUrl('assets/css/style-responsive.css'); ?>" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo baseUrl('assets/js/html5shiv.js'); ?>"></script>
    <script src="<?php echo baseUrl('assets/js/respond.min.js'); ?>"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <form class="form-signin" action="" method="POST">
        <h2 class="form-signin-heading">PLease sign in</h2>
        <div class="login-wrap">
            <?php if (isset($_SESSION['successMsg'])) { ?>
                <div class="alert alert-success fade in">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>Success!</strong> <br>
                    <?php
                    echo $_SESSION['successMsg'];
                    unset($_SESSION['successMsg']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($errorMsg) && null != $errorMsg) { ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $errorMsg; ?>
                </div>
            <?php } ?>
            <?php
            if (isset($_SESSION['login_failure'])) { ?>
                <div class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $_SESSION['login_failure'];
                    unset($_SESSION['login_failure']); ?>
                </div>
            <?php } ?>

            <input type="text" class="form-control" placeholder="Username/Email" name="username" autofocus
            >
            <input type="password" name="password" class="form-control" placeholder="Password">
            <button class="btn btn-lg btn-login btn-block" type="submit">Go</button>
        </div>

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
             class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off"
                               class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </form>
</div>


<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo baseUrl('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo baseUrl('assets/js/bootstrap.min.js'); ?>"></script>
<?php ob_end_flush(); ?>
</body>
</html>