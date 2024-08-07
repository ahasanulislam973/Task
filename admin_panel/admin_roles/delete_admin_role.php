<?php
session_start();
ob_start();
require_once '../config/config.php';
if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}

$currentFileName = basename(__FILE__);
$module = dirname(__FILE__);
$module = explode('/', $module);
$ct = count($module);
if (!hasPermission(strtolower($currentFileName), $module[$ct - 1])) {
    header('Location: ' . $accessDeniedPage);
    exit;
}

$redirectUrl = baseUrl('admin_roles/manage_admin_role.php');

// delete data from users.
$sql = "DELETE FROM admin_roles WHERE role_id = '" . $_GET['deleteId'] . "'";
if (mysqli_query($conn, $sql)) {
    $_SESSION['successMsg'] = "Data deleted successfully.";
    header('Location:' . $redirectUrl);
    exit;
} else {
    $_SESSION['errorMsg'] = "Something Wrong : " . mysqli_error();
}

ob_end_flush();