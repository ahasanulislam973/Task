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

$pageTitle = "Add Module";
$tabActive = "modules";
$subTabActive = "add_module";
$manageAdminUrl = $redirectUrl = baseUrl("modules/add_module.php");
include_once INCLUDE_DIR . 'header.php';

$createdBy = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save'])) {

        $moduleName = $_POST['module_name'];
        if (empty($moduleName)) {
            $errorMsg .= "<p>Module Name Required</p>";
        }

        if (empty($_POST['display_name'])) {
            $errorMsg .= "<p>Display Name required</p>";
        }

        if (!empty($moduleName)) {
            if (isDataExists('modules', 'module_name', $moduleName)) {
                $errorMsg .= "<p>Module name already exists. please choose a unique name.</p>";
            }
        }

        if (null == $errorMsg) {

            $data = array(
                'module_name' => cleanInput($_POST['module_name']),
                'display_name' => cleanInput($_POST['display_name']),
                'module_url' => cleanInput($_POST['module_url']),
                // 'view_order' => '0'
            );

            if (doInsert('modules', $data)) {
                $_SESSION['successMsg'] = 'Module added successfully';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Module Creation failed !!';
            }
        }
    }
}
?>

    <section id="main-content">
        <section class="wrapper site-min-height">
            <link href="<?php echo baseUrl('assets/modules/bootstrap-fileupload/bootstrap-fileupload.css'); ?>"
                  rel="stylesheet"/>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>"
                                 class=" btn btn-success btn-xs"> Manage Modules</a>
                          </span>
                        </header>

                        <div class="panel-body panel-primary">

                            <div class="row">

                                <div class="col-md-12">

                                    <?php if (isset($_SESSION['successMsg'])) {
                                        ?>
                                        <div class="alert alert-success">
                                            <strong>Success!</strong> <br>
                                            <?php
                                            echo $_SESSION['successMsg'];
                                            unset($_SESSION['successMsg']);
                                            ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($errorMsg) && null != $errorMsg) { ?>
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

                                    <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_title">Module
                                        Information </h4>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Module Name<span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="e.g. admin_roles" name="module_name"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['module_name'] : ''; ?>">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Display Name<span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="e.g. Admin Roles" name="display_name"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['display_name'] : ''; ?>">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Module URL</label>
                                        <input type="text" placeholder="e.g. admin_roles/add_admin_role.php"
                                               name="module_url"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['module_url'] : ''; ?>">
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="col-md-3">
                                        <button class="btn btn-danger btn-block btn-sm" type="submit" name="save"
                                                value="1">Save
                                        </button>
                                    </div>

                                </form><!-- Form -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>