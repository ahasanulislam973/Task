<?php
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 2/20/2019
 * Time: 12:31 PM
 */

include '../config/config.php';

function isVotingPollQuiz($cn, $categoryId)
{
    $get_ondemand_quiz_category_qry = "SELECT qz.quiz_id,qz.quiz_category_id,qcat.quiz_type FROM `quiz_category` qcat 
INNER JOIN `quiz` qz ON qcat.quiz_category_id=qz.quiz_category_id
WHERE qcat.quiz_category_id='$categoryId'";

    $rs = Sql_exec($cn, $get_ondemand_quiz_category_qry);
    $ondemand_poll_quiz_type = $ondemand_poll_quiz_id = $ondemand_poll_quiz_category_id = "";
    while ($row = Sql_fetch_array($rs)) {
        $ondemand_poll_quiz_type = Sql_Result($row, 'quiz_type');
        $ondemand_poll_quiz_id = Sql_Result($row, 'quiz_id');
        $ondemand_poll_quiz_category_id = Sql_Result($row, 'quiz_category_id');
    }

    return array(
        'quiz_type' => $ondemand_poll_quiz_type,
        'quiz_id' => $ondemand_poll_quiz_id,
        'quiz_category_id' => $ondemand_poll_quiz_category_id,
    );
}


function SetDBInfo($dbservers, $dbnames, $dbusername, $dbpassword, $dbtypes)
{
    global $Server;
    global $Database;
    global $UserID;
    global $Password;
    global $dbtype;

    $dbtype = $dbtypes;
    $Server = $dbservers;
    $Database = $dbnames;
    $UserID = $dbusername;
    $Password = $dbpassword;
}

function populateQuizCategory()
{
    global $service_Database, $service_Password, $service_UserID, $service_Server, $service_dbtype, $quiz_Database;

    SetDBInfo($service_Server, $quiz_Database, $service_UserID, $service_Password, $service_dbtype);
    $conn = connectDB();

    $qry = "SELECT DISTINCT `quiz_category_id`,`quiz_category_name` FROM `quiz_category` WHERE `quiz_category_status`='Active'";
    mysqli_query($conn, 'SET CHARACTER SET utf8');
    mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
    $rs = Sql_exec($conn, $qry);
    $QuizCategory = array();
    $QuizCategory[] = "Please Select One";
    while ($row = Sql_fetch_array($rs)) {
        $QuizCategory[$row['quiz_category_id']] = $row['quiz_category_name'];
    }
    return $QuizCategory;
}

function populateQuizName($catId)
{
    global $service_Database, $service_Password, $service_UserID, $service_Server, $service_dbtype, $quiz_Database;

    SetDBInfo($service_Server, $quiz_Database, $service_UserID, $service_Password, $service_dbtype);
    $conn = connectDB();

    $qry = "SELECT DISTINCT `quiz_id`,`quiz_title` FROM `quiz` WHERE `quiz_category_id`='$catId' AND `quiz_status`='Active'";
    mysqli_query($conn, 'SET CHARACTER SET utf8');
    mysqli_query($conn, "SET SESSION collation_connection ='utf8_general_ci'");
    $rs = Sql_exec($conn, $qry);
    $QuizName = array();
    $QuizName[] = "Please Select One";
    while ($row = Sql_fetch_array($rs)) {
        $QuizName[$row['quiz_id']] = $row['quiz_title'];
    }
    return $QuizName;
}

function populateQuizNameApp($catId)
{
    global $cn;

    $qry = "SELECT DISTINCT `quiz_id`,`quiz_title` FROM `quiz` WHERE `quiz_category_id`='$catId' AND `quiz_status`<>'Inactive' AND `quiz_status`<>'ended'";
    mysqli_query($cn, 'SET CHARACTER SET utf8');
    mysqli_query($cn, "SET SESSION collation_connection ='utf8_general_ci'");
    $rs = Sql_exec($cn, $qry);
    $QuizName = array();
    $QuizName[] = "<----- Please Choose One ----->";
    while ($row = Sql_fetch_array($rs)) {
        $QuizName[$row['quiz_id']] = $row['quiz_title'];
    }
    return $QuizName;
}

function logWrite($fileName, $logTxt)
{
    global $logEnable, $logSeparator;

    if ($logEnable) {
        $file = fopen($fileName, 'a+');
        fwrite($file, date("Y-m-d H:i:s", time()) . $logSeparator . $logTxt . PHP_EOL);
        fclose($file);
    }
    //echo $fileName.$logTxt;
  //  slpeep(100000);
}