<?php
session_start();
require_once '../config/config.php';
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

$pageTitle = "Nodelog Config";

$organizationId = $_SESSION['admin_login_info']['organization_id'];

// exit($organizationId);

switch ($organizationId) {
    case 9:
        include 'notification_summary_lib_istishon.php';
        break;
    default:
        include 'nodelog_config_lib.php';
        break;
}
