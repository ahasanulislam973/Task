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

$organizationId = $_SESSION['admin_login_info']['organization_id'];
$pageTitle = "Manage Admin Roles";
$tabActive = "admin_roles";
$subTabActive = "manage_admin_role";
$addRoleUrl = baseUrl('admin_roles/add_admin_role.php');
$getAdminRoles = doSelect('admin_roles', $organizationId);

include_once INCLUDE_DIR . 'header.php';
?>

    <!--dynamic table-->
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
                              <a href="<?php echo $addRoleUrl; ?>" class=" btn btn-danger btn-xs"> Add Admin Roles</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="15%">Role Name</th>
                                        <th width="10%">Created By</th>
                                        <th width="10%">Created</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($getAdminRoles)) { ?>
                                        <?php

                                        foreach ($getAdminRoles as $key => $row) {

                                            $roleId = !empty($row->role_id) ? $row->role_id : NULL;
                                            $updateUrl = baseUrl('admin_roles/update_admin_role.php?updateId=' . $roleId);
                                            /*$viewUrl = baseUrl('admin_roles/view_admin_role.php?viewId=' . $roleId);*/
                                            $permissionUrl = baseUrl('admin_roles/permission_manager.php?roleId=' . $roleId);
                                            $deleteUrl = baseUrl('admin_roles/delete_admin_role.php?deleteId=' . $roleId);
                                            $roleName = !empty($row->role_name) ? $row->role_name : "";;
                                            $createdBy = !empty($row->created_by) ? $row->created_by : "";
                                            $created = longDateHuman($row->created_at, 'date_time');
                                            $updateUrl .= "&role_name=" . urlencode($roleName);
                                            $permissionUrl .= "&role_name=" . urlencode($roleName);
                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $roleName; ?></a>
                                                </td>
                                                <td><?php echo $createdBy; ?></td>
                                                <td><?php echo $created; ?></td>

                                                <td class="">
                                                    <a class="btn btn-default btn-xs" title="Set Permission"
                                                       href="<?php echo $permissionUrl; ?>"><i
                                                                class="fa fa-lock"></i></a>
                                                    <!--<a class="btn btn-success btn-xs" title="View"
                                                       href="<?php /*echo $viewUrl; */ ?>"><i class="fa fa-eye"></i></a>-->
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#my_data_table').dataTable({
                order: [[3, "desc"]]
            });
        });
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>