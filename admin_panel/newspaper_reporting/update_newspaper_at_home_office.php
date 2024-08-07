<?php
session_start();
require_once '../config/service_config.php';
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

$pageTitle = "Update Newspaper At Home Office Data";
$tabActive = "newspaper_reporting";
$subTabActive = "update_newspaper_at_home_office";
$manageNewsaperAtHomeUrl = baseUrl("newspaper_reporting/newspaper_at_home_office.php");

include_once INCLUDE_DIR . 'header.php';

$userStatus = array();
$pageNotFound = FALSE;
$dataFound = FALSE;
$userProfileId = $_GET['updateId'];
if (ctype_digit($userProfileId)) {

    SetDBInfo($service_Server, $service_Database, $service_UserID, $service_Password, $service_dbtype);
    $cn = connectDB();
    $qry = "SELECT profile_id, msisdn, person_name, address as order_address, status, visit_date, created_at, updated_at FROM HimalayanUserProfile WHERE profile_id='$userProfileId'";
    $rs = Sql_exec($cn, $qry);

    $resultArr = array();
    if (Sql_Num_Rows($rs) > 0) {
        $resultObj = mysqli_fetch_object($rs);

        /*while ($row = mysqli_fetch_object($rs)) {
            $resultArr[] = $row;
        }*/
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

    if (isset($_POST['update'])) {

        extract($_POST);

        if (empty($msisdn)) {
            $errorMsg .= "<p>Mobile Number Field Required</p>";
        }

        if (empty($visit_date)) {
            $errorMsg .= "<p>Visit Date Field Required</p>";
        }

        if (empty($person_name)) {
            $errorMsg .= "<p>Person Name required</p>";
        }

        if (empty($order_address)) {
            $errorMsg .= "<p>Order Address required</p>";
        }

        if (empty($status)) {
            $errorMsg .= "<p>Status required</p>";
        }

        if (null == $errorMsg) {
            $data = array(
                'msisdn' => cleanInput($msisdn),
                'visit_date' => date('Y-m-d', strtotime(cleanInput($visit_date))),
                'person_name' => cleanInput($person_name),
                'address' => cleanInput($order_address),
                'status' => cleanInput($status),
                'updated_by' => $updatedBy,
                'updated_at' => date('Y-m-d H:i:s'),
            );

            SetDBInfo($service_Server, $service_Database, $service_UserID, $service_Password, $service_dbtype);
            $cn = connectDB();

            if (updateUserProfile('HimalayanUserProfile', $data, $userProfileId)) {
                $_SESSION['successMsg'] = 'Updated successfully';
                header('Location: ' . $manageNewsaperAtHomeUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Update failed. Something Went Wrong !!';
            }
            ClosedDBConnection($cn);
        }
    }
}


function updateUserProfile($table, $data, $userId)
{
    global $cn;
    $cols = array();
    foreach ($data as $key => $val) {
        $cols[] = "$key = '$val'";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE profile_id='$userId'";
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
                              <a href="<?php echo $manageAdminUrl; ?>" class=" btn btn-success btn-xs"> Newspaper at Home/Office</a>
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

                                        <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_title"> Newspaper at
                                            Home/Office </h4>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Person Name<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Person Name" name="person_name"
                                                   class="form-control"
                                                   value="<?php echo $userData->person_name; ?>">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Mobile Number<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Mobile No."
                                                   name="msisdn"
                                                   class="form-control"
                                                   value="<?php echo $userData->msisdn; ?>">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status">
                                                <?php foreach ($statusArr as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php if ($userData->status == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Visit Date <span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Visit Date"
                                                   name="visit_date"
                                                   class="form-control"
                                                   id="visit_date"
                                                   value="<?php echo date('Y-m-d', strtotime($userData->visit_date)); ?>">
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label>Order Address <span class="text-danger">*</span> </label>
                                            <textarea name="order_address" rows="4"
                                                      class="form-control"><?php echo $userData->order_address; ?></textarea>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-3">
                                            <button type="submit" name="update" class="btn btn-warning btn-block btn-sm"
                                                    value="1">Update
                                            </button>
                                        </div>

                                    </form><!-- Form -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <script type="text/javascript">
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

                </script>
            <?php } else {
                commonMessages(NO_DATA_FOUND);
            } ?>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>