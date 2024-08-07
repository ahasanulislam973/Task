<?php
session_start();
require_once '../config/config.php';
if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}
/*$currentFileName = basename(__FILE__);
if (!hasPermission(strtolower($currentFileName))) {
    header('Location: ' . $accessDeniedPage);
    exit;
}*/
$currentFileName = basename(__FILE__);
$module = dirname(__FILE__);
$module = explode('/', $module);
$ct = count($module);
if (!hasPermission(strtolower($currentFileName), $module[$ct - 1])) {
    header('Location: ' . $accessDeniedPage);
    exit;
}

$pageTitle = "Add Admin Role";
$tabActive = "admin_roles";
$subTabActive = "add_admin_role";
$manageAdminUrl = $redirectUrl = baseUrl("admin_roles/manage_admin_role.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

// check save button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save'])) {

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

            if (doInsert('admin_roles', $data)) {
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
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>" class=" btn btn-success btn-xs"> Manage Admin Roles</a>
                          </span>
                        </header>

                        <div class="panel-body panel-primary">

                            <div class="row">

                                <div class="col-md-6">
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
                                    <form accept-charset="utf-8" method="post" action="">

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Role Name<span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Role Name" name="role_name"
                                                   class="form-control"
                                                   value="<?php echo (isset($_POST['save'])) ? $_POST['role_name'] : ''; ?>">
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-danger btn-block btn-sm" name="save"
                                                    value="1">Save
                                            </button>
                                        </div>

                                    </form><!-- Form -->
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>