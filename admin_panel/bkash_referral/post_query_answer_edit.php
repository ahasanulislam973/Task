<?php
session_start();
require_once '../config/service_config.php';
//require_once '../config/config.php';
require_once '../lib/functions.php';

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

$pageTitle = "Post Query Answer";
$tabActive = "fb_queries";
//$subTabActive = "update_newspaper_at_home_office";
$manageCustomerCareQueriesURL = baseUrl("bkash_referral/customer_care_queries.php");

include_once INCLUDE_DIR . 'header.php';

$userStatus = array();
$pageNotFound = FALSE;
$dataFound = FALSE;
$questionId = $_GET['updateId'];
if (ctype_digit($questionId)) {

    SetDBInfo($BRef_Server, $BRef_Database, $BRef_UserID, $BRef_Password, $BRef_dbtype);
    $cn = connectDB();
    $qry = "SELECT facebook_id, `query`, response,is_sent, read_status , created_at, updated_at 
FROM fb_queries WHERE id='$questionId'";
    $rs = Sql_exec($cn, $qry);

    $resultArr = array();
    if (Sql_Num_Rows($rs) > 0) {
        $resultObj = mysqli_fetch_object($rs);

    }
    ClosedDBConnection($cn);

    $userData = $resultObj;

    if (!empty($userData)) {
        $dataFound = TRUE;
    } else {
        $dataFound = FALSE;
    }
} else {
    $pageNotFound = TRUE;
}


$updatedBy = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

// check save button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['send'])) {

        extract($_POST);

        if (empty($response)) {
            $errorMsg .= "<p>PLease type your answer</p>";
        }

        if (null == $errorMsg) {
            $data = array(
                'response' => cleanInput($response),
            );

            SetDBInfo($BRef_Server, $BRef_Database, $BRef_UserID, $BRef_Password, $BRef_dbtype);
            $cn = connectDB();

            if (postQueryAnswer($tabActive, $data, $questionId)) {
                $_SESSION['successMsg'] = 'Query Posted successfully';
                header('Location: ' . $manageCustomerCareQueriesURL);

                exit;
            } else {
                $_SESSION['errorMsg'] = 'Answer Posting failed. Something Went Wrong !!';
            }
            ClosedDBConnection($cn);
        }
    }
}


function postQueryAnswer($table, $data, $userId)
{
    global $cn;
    $cols = array();
    foreach ($data as $key => $val) {
        $cols[] = "$key = '$val'";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " ,is_sent='1',read_status='1',updated_at=NOW() WHERE id='$userId'";
    $result = Sql_exec($cn, $sql);
    if ($result > 0) {
        return true;
    }
    return false;
}


$statusArr = array(
    NULL => 'Any-',
    'Subscribed' => 'Subscribed',
    'Pending' => 'Pending',
);

?>
    <!--for datepicker loading-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <section id="main-content">
        <section class="wrapper site-min-height">
            <?php
            if ($pageNotFound == TRUE) {
                commonMessages(INVALID_PARAM_REQUEST);
            } elseif ($pageNotFound == FALSE && $dataFound == TRUE) {
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <?php echo $pageTitle; ?>
                                <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>" class=" btn btn-success btn-xs"> Query Answer post</a>
                          </span>
                            </header>

                            <div class="panel-body panel-primary">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (null != $errorMsg) { ?>
                                            <div class="alert alert-danger">
                                                <strong>Warning!</strong> <br>
                                                <?php echo $errorMsg; ?>
                                            </div>
                                        <?php } elseif (isset($_SESSION['errorMsg'])) {
                                            ?>
                                            <div class="alert alert-danger">
                                                <strong>Warning!</strong> <br>
                                                <?php
                                                echo $_SESSION['errorMsg'];
                                                unset($_SESSION['errorMsg']);
                                                ?>
                                            </div>
                                        <?php } ?>

                                    </div>

                                    <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">

                                        <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_title">Answer to the User Query </h4>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Answer<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="response" name="response"
                                                   class="form-control"
                                                   value="<?php echo $userData->response; ?>">
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-3">
                                            <button type="submit" name="send" class="btn btn-warning btn-block btn-sm"
                                                    value="1">Send
                                            </button>
                                        </div>

                                    </form><!-- Form -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            <!--    <script type="text/javascript">
                    $("#visit_date").click(function () {
                        $(this).datepicker().datepicker('show');
                    });

                    var currDate = new Date();
                    var nextDate = new Date(currDate.setDate(currDate.getDate() + 5));

                    $("#visitDate").datepicker({
                        dateFormat: 'yy-mm-dd',
                        minDate: 1,
                        maxDate: nextDate,
                    }).attr('readonly', 'true').keypress(function (event) {
                        if (event.keyCode == 8) {
                            event.preventDefault();
                        }
                    });

                </script>-->
            <?php } else {
                commonMessages(NO_DATA_FOUND);
            } ?>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>