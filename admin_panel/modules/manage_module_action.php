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

$pageTitle = "Manage Module Action";
$tabActive = "modules";
$subTabActive = "manage_module_action";
$addModuleUrl = baseUrl('modules/add_module_action.php');
$organizationId = $_SESSION['admin_login_info']['organization_id'];
$getModuleAction = getModuleActionInfo();

include_once INCLUDE_DIR . 'header.php';
?>
    <!--dynamic data table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>

    <section id="main-content">
        <section class="wrapper site-min-height">

            <div class="row">
                <div class="col-lg-12">

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

                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $addModuleUrl; ?>"
                                 class=" btn btn-warning btn-xs"> Add Module Action</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped dataTable"
                                       id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Organization</th>
                                        <th width="10%">Module Name</th>
                                        <th width="10%">Action Name</th>
                                        <th width="10%">Display Name</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($getModuleAction)) { ?>
                                        <?php
                                        foreach ($getModuleAction as $key => $row) {

                                            $actionId = !empty($row->action_id) ? $row->action_id : NULL;
                                            $updateUrl = baseUrl('modules/update_module_action.php?updateId=' . $actionId);
                                            /*$viewUrl = baseUrl('admin_users/view_admin_user.php?viewId=' . $userId);*/
                                            $deleteUrl = baseUrl('modules/delete_module_action.php?deleteId=' . $actionId);
                                            $organizationName = !empty($row->organization_name) ? $row->organization_name : "N/A";
                                            $moduleName = !empty($row->module_name) ? $row->module_name : "N/a";
                                            $actionName = !empty($row->action_name) ? $row->action_name : "N/a";
                                            $displayName = !empty($row->display_name) ? $row->display_name : "N/a";
                                            $updateUrl .="&organization_id=$row->organization_id&module_id=$row->module_id&action_name=$actionName&display_name=$displayName";
                                            ?>
                                            <tr class="gradeX">

                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $organizationName; ?></td>
                                                <td><span class="text-uppercase"><?php echo $moduleName; ?></span></td>
                                                <td><code><?php echo $actionName; ?></code></td>
                                                <td><span class="label label-warning"><?php echo $displayName; ?></span>
                                                </td>

                                                <td class="">
                                                    <a class="btn btn-primary btn-xs" title="Update"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-xs" title="Delete"
                                                       onclick="return confirm('Are you Sure??\nYou Want to Delete this item!');"
                                                       href="<?php echo $deleteUrl; ?>">
                                                        <i class="fa fa-ban"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#my_dynamic_table').dataTable({
                "aaSorting": [[4, "desc"]]
            });
        });
    </script>

    <!--Dynamic Data Table-->
    <script type="text/javascript" language="javascript"
            src="<?php echo baseUrl('assets/modules/advanced-datatable/media/js/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.js'); ?>"></script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>