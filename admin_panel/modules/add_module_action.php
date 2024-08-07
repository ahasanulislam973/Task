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

$pageTitle = "Add Module Action";
$tabActive = "modules";
$subTabActive = "add_module_action";
$manageAdminUrl = $redirectUrl = baseUrl("modules/add_module_action.php");
include_once INCLUDE_DIR . 'header.php';

$errorMsg = null;
$getModules = getModules();
$organizations = getOrganization();
$moduleActionNameList = loadModuleActionNameList();
$moduleActionDisplayNameList = loadModuleActionDisplayNameList();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save'])) {

        $organizationId = $_POST['organization_id'];
        if (empty($organizationId)) {
            $errorMsg .= "<p>Organization selection Required</p>";
        }

        $moduleId = $_POST['module_id'];
        if (empty($moduleId)) {
            $errorMsg .= "<p>Module Required</p>";
        }

        $actionName = $_POST['action_name'];
        if (empty($actionName)) {
            $errorMsg .= "<p>Module Action Name Required</p>";
        }
        $displayName = $_POST['display_name'];
        if (empty($displayName)) {
            $errorMsg .= "<p>Display Name required</p>";
        }

        if (null == $errorMsg) {

            $data = array(
                'organization_id' => cleanInput($organizationId),
                'module_id' => cleanInput($moduleId),
                'action_name' => cleanInput($actionName),
                'display_name' => cleanInput($displayName),
                // 'view_order' => '0'
            );

            if (doInsert('module_actions', $data)) {
                $_SESSION['successMsg'] = 'Module Action added successfully';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Module Action creation failed !!';
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
                        <header class="panel-heading ">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>"
                                 class=" btn btn-success btn-xs"> Manage Modules Action</a>
                          </span>
                        </header>

                        <div class="panel-body panel-primary">

                            <div class="row">

                                <div class="col-md-12">
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
                                        <label for="role">Choose Module <span class="text-danger">*</span></label>
                                        <select name="module_id" class="form-control">
                                            <?php foreach ($getModules as $key => $val) { ?>
                                                <option value="<?php echo $key ?>"
                                                    <?php if (isset($_POST['save']) && $_POST['module_id'] == $key) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $val; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Action Name<span class="text-danger">*</span> </label>

                                        <input type="text" name="action_name"
                                               placeholder="e.g. manage_admin_user.php (with exact php filename)"
                                               class="form-control" list="action_name_datalist"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['action_name'] : ''; ?>"
                                               autocomplete="off">
                                        <datalist id="action_name_datalist">
                                            <?php foreach ($moduleActionNameList as $moduleActionName) { ?>
                                                <option value="<?php echo $moduleActionName ?>">
                                                </option>
                                            <?php } ?>
                                        </datalist>
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Display Name<span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="e.g. Manage Admin User" name="display_name"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['display_name'] : ''; ?>"
                                               list="display_name_datalist"
                                               autocomplete="off">

                                        <datalist id="display_name_datalist">
                                            <?php foreach ($moduleActionDisplayNameList as $moduleActionDisplayName) { ?>
                                                <option value="<?php echo $moduleActionDisplayName ?>">
                                                </option>
                                            <?php } ?>
                                        </datalist>
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