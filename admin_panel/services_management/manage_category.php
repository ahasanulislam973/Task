<?php
session_start();
require_once '../config/config.php';
require_once '../config/service_config.php';
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

$pageTitle = "Manage Quiz/On-Demand Service Category";
$tabActive = "services_management";
$subTabActive = "manage_category";
$addQuizUrl = baseUrl('services_management/add_category.php');
//$quizCategoryList = json_decode(file_get_contents($quizCategoryListUrl));
$quizCategoryList = json_decode(file_get_contents($quizCategoryListUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));

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
                              <a href="<?php echo $addQuizUrl; ?>" class=" btn btn-info btn-xs"> Add Category</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="5%">Category Name</th>
                                        <th width="5%">Organization/Operator</th>
                                        <th width="5%">Category Image</th>
                                        <th width="5%">Category Description</th>
                                        <th width="5%">Status</th>
                                        <th width="5%">Updated By</th>
                                        <th width="5%">Updated At</th>
                                        <th width="5%">Created By</th>
                                        <th width="5%">Created At</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizCategoryList)) { ?>
                                        <?php

                                        foreach ($quizCategoryList as $key => $row) {

                                            $organization_name = !empty($row->organization_name) ? $row->organization_name : "";
                                            $quiz_category_image = !empty($row->quiz_category_image) ? $row->quiz_category_image : "";
                                            $quiz_category_description = !empty($row->quiz_category_description) ? $row->quiz_category_description : "";
                                            $quiz_category_status = !empty($row->quiz_category_status) ? $row->quiz_category_status : "";

                                            $quiz_category_name = !empty($row->quiz_category_name) ? $row->quiz_category_name : NULL;
                                            $quiz_category_id = !empty($row->quiz_category_id) ? $row->quiz_category_id : NULL;
                                            $updateUrl = baseUrl('services_management/edit_category.php?updateId=' . $quiz_category_id . "&cat_name=$quiz_category_name&image=$quiz_category_image&status=$quiz_category_status&description=$quiz_category_description");
                                            $viewUrl = baseUrl('services_management/view_category.php?viewId=' . $quiz_category_id . "&cat_name=$quiz_category_name&image=$quiz_category_image&status=$quiz_category_status&description=$quiz_category_description");
                                            $deleteUrl = baseUrl('services_management/delete_category.php?deleteId=' . $quiz_category_id);


                                            $updated_by = !empty($row->updated_by) ? $row->updated_by : "";
                                            $updated_at = longDateHuman($row->updated_at, 'date_time');
                                            $createdBy = !empty($row->created_by) ? $row->created_by : "";
                                            $created = longDateHuman($row->created_at, 'date_time');
                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <?php echo $quiz_category_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $organization_name; ?>
                                                </td>
                                                <td><img src="<?php echo $quiz_category_image; ?>" width="40"
                                                         height="40" alt="no image"/></td>
                                                <td><?php echo $quiz_category_description; ?></td>
                                                <td>
                                                    <?php if (strtoupper($quiz_category_status) == 'ACTIVE') { ?>
                                                        <span class="label label-success"> <?php echo $quiz_category_status ?></span>
                                                    <?php } else { ?>
                                                        <span class="label label-danger"><?php echo $quiz_category_status ?></span>
                                                    <?php } ?>
                                                </td>

                                                <td><?php echo $updated_by; ?></td>
                                                <td><?php echo $updated_at; ?></td>
                                                <td><?php echo $createdBy; ?></td>
                                                <td><?php echo $created; ?></td>

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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#my_data_table').dataTable({
                order: [[3, "desc"]]
            });
        });
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>