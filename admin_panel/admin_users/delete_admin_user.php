<?php
ob_start();
session_start();
require_once '../config/config.php';
if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}

$currentFileName = basename(__FILE__);
$currentModule = dirname(__FILE__);
$currentModule = explode('/', $currentModule);
$endOfModule = count($currentModule);
if (!hasPermission(strtolower($currentFileName), $currentModule[$endOfModule - 1])) {
    header('Location: ' . $accessDeniedPage);
    exit;
}

$redirectUrl = baseUrl('admin_users/manage_admin_user.php');

// delete data from users.
$sql = "DELETE FROM admin_users WHERE user_id = '" . $_GET['deleteId'] . "'";
if (mysqli_query($conn, $sql)) {
    $_SESSION['successMsg'] = "Data deleted successfully.";
    header('Location:' . $redirectUrl);
    exit;
} else {
    $_SESSION['errorMsg'] = "Something Wrong : " . mysqli_error();
}

ob_end_flush();