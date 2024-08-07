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
/*if (!hasPermission(strtolower($currentFileName))) {
    header('Location: ' . $accessDeniedPage);
    exit;
}*/

$pageTitle = "Content Delivery Report";
$tabActive = "service_reporting";
$subTabActive = "content_delivery_report";

$organizationId = $_SESSION['admin_login_info']['organization_id'];
switch ($organizationId) {
    case 9:
        include 'content_delivery_report_lib_istishon.php';
        break;
    default:
        include 'content_delivery_report_lib_mylife.php';
        break;
}