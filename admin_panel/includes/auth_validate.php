<?php

//If User is logged in the session['user_logged_in'] will be set to true
require_once './config/config.php';

//if user is Not Logged in, redirect to login.php page.
if (!isset($_SESSION['admin_login_info']['user_logged_in'])) {
    header('Location: ' . $loginUrl);
    exit;
}

?>