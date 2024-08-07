<?php
date_default_timezone_set('Asia/Dhaka'); // default datetime zone
// note: This file should be included first in every php page.
//error_reporting(E_ALL);

/*
 * Please do not change following values unless really need to
 */
//ini_set('display_errors', 'On');
$hostname = getenv('HTTP_HOST'); // get host name
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'admin_panel');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define('PROJECT_NAME', ' | Admin Panel');
define('COPYRIGHT_TEXT', 'SSD-Tech @2019');
define('PROJECT_BASE_PATH', 'http://' . $hostname . '/' . APP_FOLDER);
define('INCLUDE_DIR', BASE_PATH . "/includes/");
define('API_DIRECTORY', 'bot_service_api');
define('API_BASE_PATH', 'http://' . $hostname . '/' . API_DIRECTORY);
require_once BASE_PATH . '/helpers/helpers.php';
require_once BASE_PATH . '/helpers/queries.php';
require_once BASE_PATH . '/helpers/messages.php';
require_once BASE_PATH . '/lib/common.php';

// include '../lib/common.php';

/*
|--------------------------------------------------------------------------
| IMPORTANT URL
|--------------------------------------------------------------------------
 */

$currentUrl = "http://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'];


$loginUrl = baseUrl('login.php');
$dashboardUrl = baseUrl('index.php');
$logoutUrl = baseUrl('logout.php');
// $currentFileName = basename(__FILE__);
$accessDeniedPage = baseUrl('access_denied.php');

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */

/*
define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASSWORD', "nopass");
define('DB_NAME', "corephpadmin");
*/

$dbtype = "mysqli";
$Server = "localhost";
$UserID = "root";
$Password = "";
$Database = "admin_panel";

$panel_dbtype = "mysqli";
$panel_Server = "localhost";
$panel_UserID = "root";
$panel_Password = "";
$panel_Database = "admin_panel";

$service_dbtype = "mysqli";
$service_Server = "localhost";
$service_UserID = "root";
$service_Password = "";
$service_Database = "BOTServiceUnit";

$quiz_Database = "BOTQuizUnit";

$cms_dbtype = "mysqli";
$cms_Server = "192.168.241.110";
$cms_UserID = "root";
$cms_Password = "Nopass!234";
$cms_Database = "cms";


$trivia_quiz_dbtype = "mysqli";
$trivia_quiz_Server = "192.168.241.110";
$trivia_quiz_UserID = "root";
$trivia_quiz_Password = "Nopass!234";
$trivia_quiz_Database = "TriviaQuiz";

// himalayan times BOT nepal
$HT_dbtype = "mysqli";
$HT_Server = "localhost";
$HT_UserID = "root";
$HT_Password = "Nopass!234";
$HT_Database = "BOTServiceUnit";

//bkash referral
$BRef_dbtype = "mysqli";
$BRef_Server = "localhost";
$BRef_UserID = "root";
$BRef_Password = "Nopass!234";
$BRef_Database = "referral_program";

$conn = connectDB();

