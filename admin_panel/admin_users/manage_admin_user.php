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

$pageTitle = "Manage User";
$tabActive = "admin_users";
$subTabActive = "manage_admin_user";
$addUserUrl = baseUrl('admin_users/add_admin_user.php');
$organizationId = $_SESSION['admin_login_info']['organization_id'];
$currentUserId = $_SESSION['admin_login_info']['user_id'];
$getAdminUsers = getAdminUserInfo($organizationId);
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
                              <a href="<?php echo $addUserUrl; ?>" class=" btn btn-warning btn-xs"> Add Users</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Full Name</th>
                                        <th width="10%">User Name</th>
                                        <th width="10%">Organization/Operator</th>
                                        <th width="10%">Role</th>
                                        <th width="10%">Email</th>
                                        <th width="10%">Phone</th>
                                        <th width="5%">Status</th>
                                        <th width="10%">Created</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($getAdminUsers)) { ?>
                                        <?php
                                        foreach ($getAdminUsers as $key => $row) {


                                            $userId = !empty($row->user_id) ? $row->user_id : NULL;
                                            $updateUrl = baseUrl('admin_users/update_admin_user.php?updateId=' . $userId);
                                            /*$viewUrl = baseUrl('admin_users/view_admin_user.php?viewId=' . $userId);*/
                                            /*$permissionUrl = admin_url($this->_module . '/permission/' . $userId);*/
                                            $deleteUrl = baseUrl('admin_users/delete_admin_user.php?deleteId=' . $userId);
                                            $userFullName = !empty($row->fullname) ? $row->fullname : "";;
                                            $userName = !empty($row->username) ? $row->username : "";
                                            $organizationName = !empty($row->organization_name) ? $row->organization_name : "";
                                            $userRole = !empty($row->role_name) ? $row->role_name : "";
                                            $userEmail = !empty($row->email) ? $row->email : "";
                                            $userPhone = !empty($row->phone) ? $row->phone : "";
                                            // $userPhoto = get_admin_photo($row->photo, 'media/admin_user/', 'thumbs');
                                            $userStatus = statusCheck($row->status);
                                            $created = longDateHuman($row->created_at, 'date_time');
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $userFullName; ?></a>
                                                </td>

                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $userName; ?></a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $organizationName; ?></a>
                                                </td>

                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $userRole; ?></a>
                                                </td>

                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $userEmail; ?></a>
                                                </td>

                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $userPhone; ?></a>
                                                </td>

                                                <td><?php echo $userStatus; ?></td>
                                                <td><?php echo $created; ?></td>

                                                <td class="">
                                                    <!--<a class="btn btn-success btn-xs" title="View"
                                                       href="<?php /*echo $viewUrl; */ ?>"><i class="fa fa-eye"></i></a>-->
                                                    <a class="btn btn-primary btn-xs" title="Update"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i></a>
                                                    <?php
                                                    if ($currentUserId <> $row->user_id) { ?>
                                                        <a class="btn btn-danger btn-xs" title="Delete"
                                                           onclick="return confirm('Are you Sure??\nYou Want to Delete this item!');"
                                                           href="<?php echo $deleteUrl; ?>">
                                                            <i class="fa fa-ban"></i>
                                                        </a>
                                                    <?php } ?>
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