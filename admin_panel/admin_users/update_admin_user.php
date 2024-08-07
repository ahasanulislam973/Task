<?php
session_start();
require_once '../config/config.php';
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

$pageTitle = "Update Admin User";
$tabActive = "admin_users";
$subTabActive = "admin_manage";
$manageAdminUrl = baseUrl("admin_users/manage_admin_user.php");
include_once INCLUDE_DIR . 'header.php';
$redirectUrl = baseUrl('admin_users/manage_admin_user.php');

$pageNotFound = FALSE;
$dataFound = FALSE;
$userId = $_GET['updateId'];
if (ctype_digit($userId)) {
    $userData = getUserInfo($userId); // designation_single_fetch($_GET['updateId']);
    if (!empty($userData)) {
        $dataFound = TRUE;
    } else {
        $dataFound = FALSE;
    }
} else {
    $pageNotFound = TRUE;
}
$organizationId = $_SESSION['admin_login_info']['organization_id'];
$adminRoles = getAdminRoles($organizationId);
$organizations = getOrganization();
$createdBy = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

// check save button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update'])) {


        if (empty($_POST['fullname'])) {
            $errorMsg .= "<p>Full Name Required</p>";
        }
        /*elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST['fullname'])) {
            $errorMsg .= "Fullname only letters & white space allowed";
        }*/

        if (empty($_POST['username'])) {
            $errorMsg .= "<p>Username required</p>";
        }
        if (empty($_POST['email'])) {
            $errorMsg .= "<p>Email required</p>";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format";
        }
        $roleId = $_POST['role_id'];
        if (empty($roleId)) {
            $errorMsg .= "<p>Admin role required</p>";
        }



        if (null == $errorMsg) {
            $data = array(
                'role_id' => cleanInput($roleId),
                'organization_id' => cleanInput($_POST['organization_id']),
                'phone' => cleanInput($_POST['phone']),
                'fullname' => cleanInput($_POST['fullname']),
                'email' => cleanInput($_POST['email']),
                'username' => cleanInput($_POST['username']),
                'created_by' => $createdBy,
                'lastlogin_ip' => trim($_SERVER['REMOTE_ADDR']),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if (updateAdminUser('admin_users', $data, $userId)) {

                // $_SESSION['admin_login_info']['role_id'] = $roleId;
                $_SESSION['successMsg'] = 'Updated successfully';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Update failed. Something Went Wrong !!';
            }
        }
    }
}
?>

    <section id="main-content">
        <section class="wrapper site-min-height">

            <?php
            if ($pageNotFound == TRUE) {
                commonMessages(INVALID_PARAM_REQUEST);
            } elseif ($pageNotFound == FALSE && $dataFound == TRUE) {
                ?>

                <link href="<?php echo baseUrl('assets/modules/bootstrap-fileupload/bootstrap-fileupload.css'); ?>"
                      rel="stylesheet"/>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <?php echo $pageTitle; ?>
                                <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>" class=" btn btn-success btn-xs"> Manage Admin Users</a>
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

                                        <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_title">User
                                            Information </h4>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Full Name<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Full Name" name="fullname"
                                                   class="form-control"
                                                   value="<?php echo $userData->fullname; ?>">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>User Name<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="User Name" name="username"
                                                   class="form-control"
                                                   value="<?php echo $userData->username; ?>">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Email Address <span class="text-danger">*</span> </label>
                                            <input type="email" placeholder="Email Address" name="email"
                                                   class="form-control"
                                                   value="<?php echo $userData->email; ?>">
                                        </div>

                                        <?php if ($_SESSION['admin_login_info']['organization_id'] == 0) { ?>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="organization">Organization/Operator <span
                                                            class="text-danger">(Except Super Power)*</span></label>
                                                <select name="organization_id" class="form-control">
                                                    <?php foreach ($organizations as $key => $val) { ?>
                                                        <option value="<?php echo $key ?>">
                                                            <?php echo $val; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" id="organization_id" name="organization_id"
                                                   value="<?php echo $_SESSION['admin_login_info']['organization_id']; ?>">
                                            <?php
                                        } ?>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Role <span class="text-danger">*</span></label>
                                            <select name="role_id" class="form-control">
                                                <?php foreach ($adminRoles as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php
                                                        if ($userData->role_id == $key) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Phone Number </label>
                                            <input type="tel" placeholder="Phone Number" name="phone"
                                                   class="form-control"
                                                   value="<?php echo $userData->phone; ?>">
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-3">
                                            <button class="btn btn-warning btn-block btn-sm" type="submit" name="update"
                                                    value="1">Save
                                            </button>
                                        </div>

                                    </form><!-- Form -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            <?php } else {
                commonMessages(NO_DATA_FOUND);
            } ?>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>