<?php
ob_start();
session_start();
require '../lib/functions.php';
require_once '../config/service_config.php';

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

$redirectUrl = baseUrl('profile/upload_avatar.php' . "?avatar_id=$_REQUEST[deleteId]");
$avatar_id = $_REQUEST['deleteId'];
$url = $deleteGenderAvatarUrl . '?avatar_id=' . (isset($avatar_id) ? $avatar_id : '') . "&user_id=" . (isset($_SESSION['admin_login_info']['user_id']) ? $_SESSION['admin_login_info']['user_id'] : '');
$response = json_decode(file_get_contents($url), true);


if ($response['status_code'] == 200 || $response['status_code'] == '200') {
    $_SESSION['successMsg'] = "Content deleted successfully.";
    header('Location:' . $redirectUrl);
    exit;
} else {
    $_SESSION['errorMsg'] = "Something Wrong : " . $response['status_msg'];
}

//ob_end_flush();