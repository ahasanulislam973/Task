<?php
session_start();
require_once '../config/config.php';
if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}

$currentFileName = basename(__FILE__);
$module = dirname(__FILE__);
$module = explode('/', $module);
$ct = count($module);
if (!hasPermission(strtolower($currentFileName), $module[$ct - 1])) {
    header('Location: ' . $accessDeniedPage);
    exit;
}

$pageTitle = "Update Admin User";
$tabActive = "admin_users";
$subTabActive = "role_manage";
$manageAdminRoleUrl = baseUrl("admin_roles/manage_admin_role.php");
include_once INCLUDE_DIR . 'header.php';
$redirectUrl = baseUrl('admin_roles/manage_admin_role.php');

/*if (!hasPermission(strtolower(__CLASS__), __FUNCTION__)) {
    redirect(admin_url('user/permission_denied'));
}*/

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin user id from session
$pageNotFound = FALSE;
$dataFound = FALSE;
$roleId = $_GET['updateId'];
if (ctype_digit($roleId)) {
    $userData = getAdminRoleInfo($roleId); // designation_single_fetch($_GET['updateId']);
    if (!empty($userData)) {
        $dataFound = TRUE;
    } else {
        $dataFound = FALSE;
    }
} else {
    $pageNotFound = TRUE;
}

$errorMsg = null;
// check save button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update'])) {

        $roleName = $_POST['role_name'];
        if (empty($roleName)) {
            $errorMsg .= "<p>Role Name Required.</p>";
        }

        if (!empty($roleName)) {
            if (isDataExists('admin_roles', 'role_name', $roleName)) {
                $errorMsg .= "<p>Role name already exists. please choose a unique name. </p>";
            }
        }

        if (null == $errorMsg) {
            $data = array(
                'role_name' => cleanInput($roleName),
                'created_by' => $adminId,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $where = array(
                'role_id' => $roleId,
            );
            if (doUpdate('admin_roles', $data, $where)) {
                $_SESSION['successMsg'] = 'Role added successfully';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Role creation failed !!';
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
                              <a href="<?php echo $manageAdminRoleUrl; ?>" class=" btn btn-success btn-xs"> Manage Admin Role</a>
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

                                    <form accept-charset="utf-8" method="post" action="">

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Role Name<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Role Name" name="role_name"
                                                   class="form-control"
                                                   value="<?php echo $userData->role_name; ?>">
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-danger btn-block btn-sm" name="update"
                                                    value="1">update
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