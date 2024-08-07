<?php

$baseUrl = API_BASE_PATH . "/";

// do not delete pls
$votingPollQuizId = 28;
$votingPollQuizCategoryId = 20;
$himalayanTimesQuizId = 26;
$himalayanTimesQuizCategoryId = 19;

//for mizzima quiz
$votingPollQuizId = 28;
$votingPollQuizCategoryId = 20;
$mizzimaQuizId = 26;
$mizzimaQuizCategoryId = 19;

//for dainik Shikha 
$votigpoll_quiz_id_ds = 27;
$votingPoll_QuizId_ds = 78;

// partner organization_id
$prothomAloOrganizationId = 16; // change this for production

//prothom alo
$votingPollQuizId_ProthomAlo = 72;
$votingPollQuizCategoryId_ProthomAlo = 25;
$votingPollLogUrl_ProthomAlo = $baseUrl . "reporting/prothomAloVotingReport.php";
$votingsummeryUrl = $baseUrl . "reporting/voting_summery.php";
$prothomAloDashboardReportURL = $baseUrl . "reporting/prothomAloDashboardReport.php";
$votingSummaryExprtUrl__ProthomAlo = $baseUrl . "export_data/online_vote_prothom_alo_export.php";
$votingSummaryExprtUrl = $baseUrl . "export_data/online_vote_summery_export.php";
$votingPollLExprtUrl = $baseUrl . "export_data/voting_poll_export.php";

$nodeNameReportUrl = $baseUrl . "reporting/nodeNameReport.php";

/////
///
//for mizzima quiz for production
// $votingPollQuizId = 32;
// $votingPollQuizCategoryId = 22;
$mizzimaQuizId = 31;
$mizzimaQuizCategoryId = 21;

$breakingNewsCategoryId = 27;
$senderMailForAll = "vasmarketing@monitor.ssd-tech.com";



$quizNameReportUrl = $baseUrl . "reporting/quizNameReport.php";

$quizRevenueReportUrl = $baseUrl . "reporting/quizRevenueReport.php";
$quizRevenueReportExportUrl = $baseUrl . "export_data/quizRevenueReportExport.php";

$getQuizAndOndemandQueries = $baseUrl . "reporting/quizAndOndemandQueries.php";
$nodeLogRawDataUrl = $baseUrl . "reporting/nodeLogRawData.php";
$lineChartDataUrl = $baseUrl . "reporting/serviceLineChartData.php";
$quizCompletionStatusUrl = $baseUrl . "reporting/quizCompletionStatusReporting.php";
$topScorerUrl = $baseUrl . "reporting/bestScorerReporting.php";
$quizChargingLogUrl = $baseUrl . "reporting/quizChargingLogReporting.php";
$quizSummaryUrl = $baseUrl . "reporting/quizSummaryReporting.php"; //newly added
$contentPushHistoryUrl = $baseUrl . "reporting/cmsContentPushReporting.php";
$contentPushHistoryUrl_Istishon = $baseUrl . "reporting/cmsContentPushReporting_Istishon.php";
$quizLogUrl = $baseUrl . "reporting/quizLogReporting.php";
$votingPollLogUrl = $baseUrl . "reporting/votingPollLogReporting.php";
$userSubscriptionHistoryUrl = $baseUrl . "reporting/userSubHistoryReporting.php";
$subscriptionSummaryUrl = $baseUrl . "reporting/subscriptionSummaryReporting.php"; //newly added
$currentSubscriberBaseUrl = $baseUrl . "reporting/cmsCurrentSubBaseReporting.php";
$totalQuizUserUrl = $baseUrl . "reporting/quizTotalUserReporting.php";
$serviceTotalUserUrl = $baseUrl . "reporting/serviceTotalUserReporting.php";
$quizActivationUrl = $baseUrl . "reporting/quizActivationReporting.php";
$notificationSummaryUrl = $baseUrl . "reporting/notificationSummaryReporting.php"; //newly added
$notificationSummaryUrl_Istishon = $baseUrl . "reporting/notificationSummaryReporting_Istishon.php"; //newly added
$quizRankListUrl = $baseUrl . "reporting/quizRankList.php"; //newly added
$quizRankListExprtUrl = $baseUrl . "reporting/quizRankList.php"; //newly added
$serviceUsedByUserLogUrl = $baseUrl . "reporting/serviceUsedByUserLogReporting.php";
$totalLogUrl = $baseUrl . "reporting/totalLogReporting.php";
$votingPollResult = $baseUrl . "reporting/votingPollresult.php";
$bkashReferralTotalUrl = $baseUrl . "reporting/bkashReferralTotalReporting.php";
$bkashReferralMassLineChartDataUrl = $baseUrl . "reporting/bkashReferralMassLineChartData.php";
$bkashReferralFbBarChartDataUrl = $baseUrl . "reporting/bkashReferralFbBarChartData.php";

$consolidatedReportBkashReferralUrl = $baseUrl . "reporting/consolidatedReportBkashReferral.php"; //newly added
$referrerDetailsReportBkashReferralUrl = $baseUrl . "reporting/referrerDetailsReportBkashReferral.php"; //newly added

//for Istishon BOT
$max_audio_size_mb = 8;
$max_video_size_mb = 10;
$istishonBotTotalUrl = $baseUrl . "reporting/istishonBotTotalReporting.php";
$istishonBotCategoryChartDataUrl = $baseUrl . "reporting/istishonBotCategoryChartData.php";
$istishonBotTextReplyReportingUrl = $baseUrl . "reporting/istishonBotTextReplyReporting.php";

$serviceImagePath = $baseUrl . "service_image_files/";
$dashBoardQuizActivationImgUrl = $baseUrl . "service_image_files/desh_quiz .jpg";
$dashBoardQuizTopScorerImgUrl = $baseUrl . "service_image_files/top_quizer.png";

$quizContentListUrl = $baseUrl . "service_info_modify/quizContentList.php";
$serviceContentListUrl = $baseUrl . "service_info_modify/serviceContentList.php";
$reportingServiceNameUrl = $baseUrl . "service_info_modify/cmsServiceName.php";
$contentUploadableServiceNameUrl = $baseUrl . "service_info_modify/cmsContentUploadableServiceName.php";
$genderAvatarListUrl = $baseUrl . "service_info_modify/genderAvatarList.php";

$addCategoryApiUrl = $baseUrl . "service_info_modify/addCategory.php";
$addQuizApiUrl = $baseUrl . "service_info_modify/addQuiz.php";

$deleteServiceContentUrl = $baseUrl . "service_info_modify/deleteServiceContent.php";
$deleteQuizContentUrl = $baseUrl . "service_info_modify/deleteQuizContent.php";
$pushQuizContentUrl = $baseUrl . "service_info_modify/pushQuizContent.php";
$pushQuizScoreUrl = $baseUrl . "service_info_modify/pushQuizScore.php";
$deleteGenderAvatarUrl = $baseUrl . "service_info_modify/deleteAvatar.php";

$deleteCategoryUrl = $baseUrl . "service_info_modify/deleteCategory.php";
$deleteQuizUrl = $baseUrl . "service_info_modify/deleteQuiz.php";

$quizListUrl = $baseUrl . "service_info_modify/quizList.php";
$quizCategoryListUrl = $baseUrl . 'service_info_modify/quizCategoryList.php';

$quizNameUrl = $baseUrl . "service_info_modify/quizName.php";
$quizNameAppUrl = $baseUrl . "service_info_modify/quizNameApp.php";
$quizCategoryNameUrl = $baseUrl . "service_info_modify/quizCategoryName.php";
$telenorCategoryNameUrl = $baseUrl . 'service_info_modify/telenorCategoryName.php';
$avatarDisplayOrderUrl = $baseUrl . "service_info_modify/avatarDisplayOrder.php";

$updateQuizContentApiUrl = $baseUrl . "service_info_modify/updateQuizContent.php";
$updateServiceContentApiUrl = $baseUrl . "service_info_modify/updateServiceContent.php";
$updateAvatarApiUrl = $baseUrl . "service_info_modify/updateAvatar.php";

$newOldUserReportingUrl = $baseUrl . "service_info_modify/newOldUserList.php"; //newly added
$newOldUserExcelReportUrl = $baseUrl . "export_data/newOldUserExcelReport.php"; //newly added

$quizLogExprtUrl = $baseUrl . "export_data/quizLog.php";

$pollresultExprtUrl = $baseUrl . "export_data/pollresult.php";
$ondemandLogUrl = $baseUrl . "export_data/ondemandLog.php";
$exportDatanSendMail = $baseUrl . "export_data/exportDatanSendMail.php";
$himalayanLogExportUrl = $baseUrl . "export_data/himalayanLog.php";
$himalayanLogExportDataSendMail = $baseUrl . "export_data/himalayanLogAndSendMail.php";
$himalayanAllReportExportDataSendMail = $baseUrl . "export_data/himalayanAllReportExportAndSendMail.php";
$quizLogExprtAndSendMail = $baseUrl . "export_data/quizLogAndSendMail.php";
$quizChargingLogExprtUrl = $baseUrl . "export_data/quizChargingLog.php";
$quizSummaryExprtUrl = $baseUrl . "export_data/quizSummary.php"; //newly added
$quizCompletionStatusExprtUrl = $baseUrl . "export_data/quizCompletionStatus.php";
$serviceUsedByUserLogExportUrl = $baseUrl . "export_data/serviceUsedByUserLog.php";

$serviceContentPushExprtUrl = $baseUrl . "export_data/serviceContentPush.php";
$serviceContentPushExprtUrl_Istishon = $baseUrl . "export_data/serviceContentPush_Istishon.php";
$subSummaryExprtUrl = $baseUrl . "export_data/subSummary.php"; //newly added
$subHistoryExprtUrl = $baseUrl . "export_data/subHistory.php";
$currentSubBaseExprtUrl = $baseUrl . "export_data/currentSubBase.php";
$notificationSummaryExprtUrl = $baseUrl . "export_data/notificationSummary.php"; //newly added
$notificationSummaryExprtUrl_Istishon = $baseUrl . "export_data/notificationSummary_Istishon.php"; //newly added



$pushSmsUrl = PROJECT_BASE_PATH . '/' . "notification_module/send_notification_himalayan.php"; //newly added for send push-sms to himalayan
$pushSmsUrlBd = PROJECT_BASE_PATH . '/' . 'notification_module/send_notification.php'; // for bd user


//jagofm
$jagofmDashboardReportURL = $baseUrl . "reporting/jagofmDashboardReport.php";

//ntv
$ntvDashboardReportURL = $baseUrl . "reporting/ntvDashboardReport.php";
$ntvReportUrl = $baseUrl . "reporting/ntvReport.php";
$ntvExprtUrl = $baseUrl . "export_data/ntvReportExport.php";

///fff
$fffDashboardReportURL = $baseUrl . "reporting/fffDashboardReport.php";
$fff_user_history = $baseUrl . "reporting/fff_user_history_report.php";
$fff_user_history_exprt = $baseUrl . "export_data/fff_user_history_export.php";

//Reckitt
$reckittDashboardReportURL = $baseUrl . "reporting/reckittDashboardReport.php";
$reckittPledgeReportUrl = $baseUrl . "reporting/reckittPledgeReport.php";
$reckittPledgeExprtUrl = $baseUrl . "export_data/reckittPledgeReportExport.php";
$bkashReferralFbBarChartDataUrl = $baseUrl . "reporting/bkashReferralFbBarChartData.php";

//mtk horoscope
$mtkpersonalizeSubHistory = $baseUrl . "reporting/mtkpersonalizeSubReporting.php";
$mtkpersonalizeSubExprt = $baseUrl . "export_data/mtkpersonalizeSubExport.php";


//sohoj reporting & audra
$getStartedDataUrl = $baseUrl . "reporting/sohojGetStartedReporting.php";
$getStartedDataServerSideUrl = $baseUrl . "reporting/sohojGetStartedServerSideReport.php";
$UserDataServerSideUrl = $baseUrl . "reporting/sohojUserDataServerSideReport.php";
$getStartedDataExprtUrl = $baseUrl . "export_data/sohojGetStartedDataExport.php";
$userDataExportUrl = $baseUrl . "export_data/sohojUserDataExport.php";
$CAssurebotLeadsDataServerSideUrl = $baseUrl . "reporting/CAssureBotLeadsServerSideReport.php";
$CAssurebotLeadsDataExprtUrl = $baseUrl . "export_data/CAssureBotLeadsDataExport.php";
$nodelogDataServerSideUrl = $baseUrl . "reporting/nodelogServerSideReport.php";
$nodelogDataExprtUrl = $baseUrl . "export_data/nodelogDataExport.php";
//istishon

$textReplyDataExprtUrl = $baseUrl . "export_data/textReplyDataExport.php";

//oppo
$oppReportServerSideUrl = $baseUrl . "reporting/oppReportServerSideReport.php";
$OPPODataExprtUrl = $baseUrl . "export_data/OPPODataExport.php";

//user queries Ghoori learning
$user_queries_serverside_url = $baseUrl . "reporting/user_queries_serverside_Reporting.php?";
$admin_reply_url = $baseUrl . "reporting/adminReply.php?";
$UserQueryExprtUrl = $baseUrl . "export_data/user_query_export.php?";
$logEnable = true;

$serviceDetailsArray = array(
    'DeenerkothaMylifeDailyAuto' => array(
        'DeenerkothaMylifeDailyAutoOne' => 'DeenerkothaMylifeDailyAutoOne',
        'DeenerkothaMylifeDailyAutoTwo' => 'DeenerkothaMylifeDailyAutoTwo',
    ),
    'HoroscopeMylifeDailyAuto' => array(
        'HoroscopeMylifeDailyAutoTula' => 'HoroscopeMylifeDailyAutoTula',
        'HoroscopeMylifeDailyAutoSingho' => 'HoroscopeMylifeDailyAutoSingho',
        'HoroscopeMylifeDailyAutoMokor' => 'HoroscopeMylifeDailyAutoMokor',
        'HoroscopeMylifeDailyAutoMithun' => 'HoroscopeMylifeDailyAutoMithun',
        'HoroscopeMylifeDailyAutoMesh' => 'HoroscopeMylifeDailyAutoMesh',
        'HoroscopeMylifeDailyAutoMeen' => 'HoroscopeMylifeDailyAutoMeen',
        'HoroscopeMylifeDailyAutoKumbho' => 'HoroscopeMylifeDailyAutoKumbho',
        'HoroscopeMylifeDailyAutoKorkot' => 'HoroscopeMylifeDailyAutoKorkot',
        'HoroscopeMylifeDailyAutoKonnya' => 'HoroscopeMylifeDailyAutoKonnya',
        'HoroscopeMylifeDailyAutoDhonu' => 'HoroscopeMylifeDailyAutoDhonu',
        'HoroscopeMylifeDailyAutoBrishchik' => 'HoroscopeMylifeDailyAutoBrishchik',
        'HoroscopeMylifeDailyAutoBrish' => 'HoroscopeMylifeDailyAutoBrish',
    ),
    'DeenerkothaMylifeDailyAuto_Digi' => array(
        'DeenerkothaMylifeDailyAuto_DigiOne' => 'DeenerkothaMylifeDailyAuto_DigiOne',
        'DeenerkothaMylifeDailyAuto_DigiTwo' => 'DeenerkothaMylifeDailyAuto_DigiTwo',
    ),
    'HoroscopeMylifeDailyAuto_Digi' => array(
        'HoroscopeMylifeDailyAuto_DigiTula' => 'HoroscopeMylifeDailyAuto_DigiTula',
        'HoroscopeMylifeDailyAuto_DigiSingho' => 'HoroscopeMylifeDailyAuto_DigiSingho',
        'HoroscopeMylifeDailyAuto_DigiMokor' => 'HoroscopeMylifeDailyAuto_DigiMokor',
        'HoroscopeMylifeDailyAuto_DigiMithun' => 'HoroscopeMylifeDailyAuto_DigiMithun',
        'HoroscopeMylifeDailyAuto_DigiMesh' => 'HoroscopeMylifeDailyAuto_DigiMesh',
        'HoroscopeMylifeDailyAuto_DigiMeen' => 'HoroscopeMylifeDailyAuto_DigiMeen',
        'HoroscopeMylifeDailyAuto_DigiKumbho' => 'HoroscopeMylifeDailyAuto_DigiKumbho',
        'HoroscopeMylifeDailyAuto_DigiKorkot' => 'HoroscopeMylifeDailyAuto_DigiKorkot',
        'HoroscopeMylifeDailyAuto_DigiKonnya' => 'HoroscopeMylifeDailyAuto_DigiKonnya',
        'HoroscopeMylifeDailyAuto_DigiDhonu' => 'HoroscopeMylifeDailyAuto_DigiDhonu',
        'HoroscopeMylifeDailyAuto_DigiBrishchik' => 'HoroscopeMylifeDailyAuto_DigiBrishchik',
        'HoroscopeMylifeDailyAuto_DigiBrish' => 'HoroscopeMylifeDailyAuto_DigiBrish',
    ),
    'NewsIstishon' => array(
        'NewsIstishon' => 'NewsIstishon'
    ),
    'IslamDailyIstishon' => array(
        'IslamDailyIstishon' => 'IslamDailyIstishon'
    ),
    'HoroscopeIstishon' => array(
        'HoroscopeIstishon' => 'HoroscopeIstishon'
    ),
    /*'DailyBuzzIstishon' => array(
        'DailyBuzzLoveQuotes' => 'DailyBuzzLoveQuotes',
        'DailyBuzzRelationshipTips' => 'DailyBuzzRelationshipTips',
        'DailyBuzzWordOfTheDay' => 'DailyBuzzWordOfTheDay',
    ),*/
    'DailyBuzzLoveQuotes' => array(
        'DailyBuzzLoveQuotes' => 'DailyBuzzLoveQuotes',
    ),
    'DailyBuzzRelationshipTips' => array(
        'DailyBuzzRelationshipTips' => 'DailyBuzzRelationshipTips',
    ),
    'DailyBuzzWordOfTheDay' => array(
        'DailyBuzzWordOfTheDay' => 'DailyBuzzWordOfTheDay',
    ),


);
