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

$logSeparator = "|";
date_default_timezone_set("Asia/Dhaka");
$logFileName = "logs/PUSH_QUIZ_CONTENT_" . (string)date("Y_m_d_A", time()) . ".txt";
$logTxt = json_encode($_REQUEST) . $logSeparator;

$questionInfo = json_decode($_REQUEST['jsonData'], true);

$message = array(
    "actionType" => 'liveQuestion',
    "quiz_category_name" => $questionInfo['quiz_category_name'],
    "quiz_title" => $questionInfo['quiz_title'],
    "question_id" => $questionInfo['question_id'],
    "quiz_category_id" => $questionInfo['quiz_category_id'],
    "quiz_id" => $questionInfo['quiz_id'],
    "question_image" => $questionInfo['question_image'] <> '' ? $questionInfo['question_image'] : 'NA',
    "question_audio" => $questionInfo['question_audio'] <> '' ? $questionInfo['question_audio'] : 'NA',
    "question_video" => $questionInfo['question_video'] <> '' ? $questionInfo['question_video'] : 'NA',
    "question_text" => $questionInfo['question_text'] <> '' ? $questionInfo['question_text'] : 'NA',
    "question_option" => json_decode($questionInfo['question_option'], true),
    "correct_ans_reply" => $questionInfo['correct_ans_reply'] <> '' ? $questionInfo['correct_ans_reply'] : 'NA',
    "wrong_ans_reply" => $questionInfo['wrong_ans_reply'] <> '' ? $questionInfo['wrong_ans_reply'] : 'NA',
    "question_countdown" => $questionInfo['question_countdown'] <> '' ? $questionInfo['question_countdown'] : 'NA',
    "question_ans" => $questionInfo['question_ans'],
    "question_point" => $questionInfo['question_point']
);
$messageBody = array("QUIZ_APP_NOTIFICATION_DATA" => json_encode($message, true));


$questionId = $_REQUEST['pushId'];
$organizationId = $_SESSION['admin_login_info']['organization_id'];
$userId = (isset($_SESSION['admin_login_info']['user_id']) ? $_SESSION['admin_login_info']['user_id'] : '');

$redirectUrl = baseUrl('content_management/manage_quiz_content.php' . "?quiz_id=" . $questionInfo['quiz_id'] . "&category_id=" . $questionInfo['quiz_category_id']);

$url = $pushQuizContentUrl . "?organization_id=$organizationId&question_id=" . (isset($questionId) ? $questionId : '') . "&user_id=" . $userId;

?>
<script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.2.js"></script>
<script>
    var pubnub;
    const subscribe_key = "sub-c-a4cbd136-7536-11e9-89f1-56e8a30b5f0e";
    const publish_key = "pub-c-231068b6-959b-448c-be88-3edab7c59faa";
    const secret_key = "sec-c-YWUyMWQ3NWYtN2Y3ZC00OGU1LThiMDEtZDY4NGY3ZGM4Njli";


    function publishQuestionAnswer() {
        pubnub = new PubNub({
            subscribeKey: subscribe_key,
            publishKey: publish_key,
            secretKey: secret_key,
            ssl: true
        });

        pubnub.publish({
                message: <?php echo json_encode($messageBody, true);?>,
                channel: 'question_post',
                sendByPost: false, // true to send via post
                storeInHistory: false //override default storage options
            },
            function (status, response) {
                if (status.error) {
                    // handle error
                    console.log(status);
                } else {
                    console.log("message Published w/ timetoken", response);
                    alert("message Published: " + JSON.stringify(response));

                }
            });

    }

</script>
<?php
//$PushChannel='pubNub';
$PushChannel = 'firebase';
if ($PushChannel == 'firebase') {
    $firebasePushSDKUrl = "";
} else {
    echo '<script type="text/javascript">',
    'publishQuestionAnswer();',
    '</script>';

}


$response = json_decode(file_get_contents($url), true);
//echo '<pre>';
//print_r($message);
//print_r($response);
//echo json_encode($message);


$logTxt .= json_encode($messageBody) . $logSeparator . $url . $logSeparator . json_encode($response) . $logSeparator . $redirectUrl;
logWrite($logFileName, $logTxt);

if ($response['status_code'] == 200 || $response['status_code'] == '200') {
    $_SESSION['successMsg'] = "Content Pushed successfully.";
    ?>
    <script>
        setTimeout(function () {
            window.location.replace("<?php echo $redirectUrl;?>");
        }, 2000);
    </script>
    <?php
    exit;
} else {
    $_SESSION['errorMsg'] = "Something Wrong : " . $response['status_msg'];
}
?>

