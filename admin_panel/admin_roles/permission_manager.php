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

$pageTitle = "Permission Manager";
$tabActive = "admin_roles";
$subTabActive = "manage_admin_role";

include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin user id from session

if (!isset($_REQUEST['organization_id']) || $_REQUEST['organization_id'] == '') {
    $organizationId = $_SESSION['admin_login_info']['organization_id'];
} else {
    $organizationId = $_REQUEST['organization_id'];
}

$pageNotFound = $dataFound = FALSE;
$organizations = getOrganization();

$roleId = $_GET['roleId'];
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


/*$fp = fopen('post.txt', 'a+');
fwrite($fp, json_encode($_POST) . PHP_EOL);
fclose($fp);*/

$errorMsg = null;
// check save button
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $posts = $_POST;

    if (!empty($posts)) {
        $organizationId = $posts['organization_id'];
        $getPageModules = doSelect('modules', '*');
        if (!empty($getPageModules)) {
            /*   print "<pre>";
               print_r($getPageModules);
            */
            //  $logTxt = json_encode($posts, true);

            foreach ($getPageModules as $moduleIndex => $module) {

                if (isset($posts[$module->module_name]))
                    $hasChecked = $posts[$module->module_name];
                else
                    $hasChecked = array();


                /*$logTxt = json_encode($hasChecked, true) . PHP_EOL;
                $fileName = 'aLog.txt';
                $file = fopen($fileName, 'a+');
                fwrite($file, date("Y-m-d H:i:s", time()) . '|' . $logTxt . PHP_EOL);
                fclose($file);*/


                $getPageModuleAction = getModuleActions(array('module_id' => $module->module_id, 'organization_id' => $organizationId));

                if (is_array($getPageModuleAction) || is_object($getPageModuleAction)) {

                    foreach ($getPageModuleAction as $index => $actions) {
                        $aPermission = getPermission(array('role_id' => $roleId, 'module' => $module->module_name, 'action' => trim($actions->action_name), 'organization_id' => $organizationId));

                        /*   $fileName = 'aPermission.txt';
                           $file = fopen($fileName, 'a+');
                           fwrite($file, date("Y-m-d H:i:s", time()) . '|' . json_encode($aPermission) . "|" . $actions->action_name . PHP_EOL);
                           fclose($file);*/

                        if ($aPermission) {
                            $values = (in_array(trim($actions->action_name), $hasChecked)) ? '1' : '0';

                            /*$fileName = 'aPermission.txt';
                            $file = fopen($fileName, 'a+');
                            fwrite($file, date("Y-m-d H:i:s", time()) . '|' . json_encode($hasChecked) . "|" . $actions->action_name . "|" . $values . PHP_EOL);
                            fclose($file);*/

                            $updateData = array(
                                'value' => $values
                            );

                            doUpdate('permissions', $updateData, array('permission_id' => $aPermission->permission_id, 'role_id' => $roleId, 'organization_id' => $organizationId, 'module' => $module->module_name));

                        } else {
                            $values = (in_array($actions->action_name, $hasChecked)) ? '1' : '0';
                            $saveData = array(
                                'role_id' => $roleId,
                                'organization_id' => $organizationId,
                                'module' => $module->module_name,
                                'action' => $actions->action_name,
                                'value' => $values
                            );
                            doInsert('permissions', $saveData);
                        }

                    }
                }
            }

            $_SESSION['successMsg'] = 'Change saved successfully.';
            $redirectUrl = baseUrl('admin_roles/permission_manager.php?roleId=' . $roleId . "&role_name=$_REQUEST[role_name]&organization_id=$organizationId");
            echo('<meta http-equiv="refresh" content="0;url=' . $redirectUrl . '">');  // redirect after few second
            exit;
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
            <div class="row">
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-md-12">

                            <?php if (isset($_SESSION['successMsg'])) { ?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> <br>
                                    <?php
                                    echo $_SESSION['successMsg'];
                                    unset($_SESSION['successMsg']);
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
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
                                <div class="row">

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h3 for="rolename">Role Name: <span
                                                    class="text-danger"><?php echo $_REQUEST['role_name']; ?></span>
                                        </h3>
                                    </div>

                                    <?php if ($_SESSION['admin_login_info']['organization_id'] == 0) { ?>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="organization">Organization/Operator <span
                                                        class="text-danger">(Except Super Power)*</span></label>
                                            <select name="organization_id" id="organization_id" form="submit_permission"
                                                    class="form-control" onchange="reloadOrganization(this)">
                                                <?php foreach ($organizations as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php if (isset($_REQUEST['organization_id']) && $_REQUEST['organization_id'] == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" form="submit_permission" id="organization_id"
                                               name="organization_id"
                                               value="<?php echo $_SESSION['admin_login_info']['organization_id']; ?>">
                                        <?php
                                    } ?>

                                </div>
                                <?php
                                $getPageModules = doSelect('modules', '*');
                                if (!empty($getPageModules)) { ?>
                                    <form method="POST" id="submit_permission" action="">
                                        <?php foreach ($getPageModules as $module) { ?>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="displaName"><?php echo $module->display_name; ?></label>
                                                    <fieldset>
                                                        <?php
                                                        $getPageModuleAction = getModuleActions(array('module_id' => $module->module_id, 'organization_id' => $organizationId));
                                                        if (!empty($getPageModuleAction)) {
                                                            foreach ($getPageModuleAction as $key => $actions) {
                                                                ?>

                                                                <div class="checkbox checkbox-success">
                                                                    <input type="checkbox"
                                                                           id="<?php echo md5($module->module_name . $actions->action_name); ?>"
                                                                           value="<?php echo trim($actions->action_name); ?>"
                                                                           name="<?php echo $module->module_name; ?>[]"<?php if (hasActionPermission($actions->action_name, $organizationId, $module->module_name, $roleId)) { ?> checked="checked" <?php } ?>>
                                                                    <label for="<?php echo md5($module->module_name . $actions->action_name); ?>">
                                                                        <?php echo $actions->display_name; ?>
                                                                        &nbsp
                                                                    </label>

                                                                    <div class="clearfix"></div>
                                                                </div>

                                                            <?php } ?>
                                                        <?php } ?>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="clearfix"></div>
                                                <button type="submit" class="btn btn-danger">Save Changes</button>
                                            </div>
                                        </div>

                                    </form>
                                <?php } ?>
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

<script type="text/javascript">

    function reloadOrganization(sel) {

        var x = 0;
        x = sel.value;
        <?php  $uri = PROJECT_BASE_PATH . "/admin_roles/permission_manager.php?roleId=$_REQUEST[roleId]&role_name=$_REQUEST[role_name]&organization_id=";?>
        window.location.replace('<?php echo $uri;?>' + x);

    }
</script>
<style type="text/css">

    .checkbox {
        padding-left: 20px;
    }

    .checkbox label {
        display: inline-block;
        position: relative;
        padding-left: 5px;
    }

    .checkbox label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 3px;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    .checkbox label::after {
        display: inline-block;
        position: absolute;
        width: 16px;
        height: 16px;
        left: 0;
        top: 0;
        margin-left: -20px;
        padding-left: 3px;
        padding-top: 1px;
        font-size: 11px;
        color: #555555;
    }

    .checkbox input[type="checkbox"] {
        opacity: 0;
    }

    .checkbox input[type="checkbox"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px;
    }

    .checkbox input[type="checkbox"]:checked + label::after {
        font-family: 'FontAwesome';
        content: "\f00c";
    }

    .checkbox input[type="checkbox"]:disabled + label {
        opacity: 0.65;
    }

    .checkbox input[type="checkbox"]:disabled + label::before {
        background-color: #eeeeee;
        cursor: not-allowed;
    }

    .checkbox.checkbox-circle label::before {
        border-radius: 50%;
    }

    .checkbox.checkbox-inline {
        margin-top: 0;
    }

    .checkbox-primary input[type="checkbox"]:checked + label::before {
        background-color: #428bca;
        border-color: #428bca;
    }

    .checkbox-primary input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-danger input[type="checkbox"]:checked + label::before {
        background-color: #d9534f;
        border-color: #d9534f;
    }

    .checkbox-danger input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-info input[type="checkbox"]:checked + label::before {
        background-color: #5bc0de;
        border-color: #5bc0de;
    }

    .checkbox-info input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-warning input[type="checkbox"]:checked + label::before {
        background-color: #f0ad4e;
        border-color: #f0ad4e;
    }

    .checkbox-warning input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-success input[type="checkbox"]:checked + label::before {
        background-color: #5cb85c;
        border-color: #5cb85c;
    }

    .checkbox-success input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

</style>

<?php

function logWriteDeeper($fileName, $logTxt)
{
    global $logEnable, $logSeparator;

    if ($logEnable) {

        $file = fopen($fileName, 'a+');
        fwrite($file, date("Y-m-d H:i:s", time()) . $logSeparator . $logTxt . PHP_EOL);
        fclose($file);
    }

}

include_once INCLUDE_DIR . 'footer.php'; ?>

