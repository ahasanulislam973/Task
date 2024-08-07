<?php
session_start();
require '../lib/functions.php';
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

$pageTitle = "Manage Quiz/On-Demand Service ";
$tabActive = "services_management";
$subTabActive = "manage_quiz";
$addQuizUrl = baseUrl('services_management/add_quiz.php');

$getQuizList = json_decode(file_get_contents($quizListUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'] . '&category_id=' . (isset($_REQUEST['quiz_category_id']) ? $_REQUEST['quiz_category_id'] : 0)));
//$categoryName = populateQuizCategory();
$categoryName = json_decode(file_get_contents($quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));

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
                              <a href="<?php echo $addQuizUrl; ?>" class=" btn btn-danger btn-xs"> Add New Quiz</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <form accept-charset="utf-8" id="category_form" enctype="multipart/form-data">

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="role">Choose Quiz/On-Demand Service Category <span
                                                class="text-danger">*</span></label>
                                    <select name="quiz_category" id="quiz_category" class="form-control smart_select "
                                            onchange="getCategory(this);">
                                        <?php foreach ($categoryName as $key => $val) { ?>
                                            <option value="<?php echo $key ?>"
                                                <?php if (isset($_REQUEST['quiz_category_id']) && $_REQUEST['quiz_category_id'] == $key) { ?> selected="selected" <?php } ?>>
                                                <?php echo $val; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </form>

                            <div class="adv-table">
                                <table class="display table table-bordered" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="5%">Quiz Title</th>
                                        <th width="5%">Image</th>
                                        <th width="5%">Description</th>
                                        <!-- <th width="5%">Options</th>-->
                                        <th width="5%">Q. Limit</th>
                                        <th width="3%">BenchMark</th>
                                        <th width="3%">Start Time</th>
                                        <th width="3%">End Time</th>
                                        <th width="3%">Charge Amount</th>
                                        <th width="10%">Status</th>
                                        <th width="5%">Updated By</th>
                                        <th width="5%">Updated At</th>
                                        <th width="5%">Created By</th>
                                        <th width="5%">Created At</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($getQuizList)) { ?>
                                        <?php

                                        foreach ($getQuizList as $key => $row) {

                                            $quiz_description = !empty($row->quiz_description) ? $row->quiz_description : NULL;
                                            $quiz_title = !empty($row->quiz_title) ? $row->quiz_title : NULL;
                                            $quiz_id = !empty($row->quiz_id) ? $row->quiz_id : NULL;
                                            $quiz_category_id = !empty($row->quiz_category_id) ? $row->quiz_category_id : '';

                                            $deleteUrl = baseUrl('services_management/delete_quiz.php?deleteId=' . $quiz_id . "&quiz_category_id=$quiz_category_id");
                                            $quiz_image = !empty($row->quiz_image) ? $row->quiz_image : "";
                                            $question_limit = !empty($row->question_limit) ? $row->question_limit : "";
                                            $Bench_mark_point = !empty($row->Bench_mark_point) ? $row->Bench_mark_point : "";
                                            $quiz_start_time = !empty($row->quiz_start_time) ? $row->quiz_start_time : "";
                                            $quiz_end_time = !empty($row->quiz_end_time) ? $row->quiz_end_time : "";
                                            $charging_amount = !empty($row->charging_amount) ? $row->charging_amount : "";
                                            $quiz_status = !empty($row->quiz_status) ? $row->quiz_status : "";

                                            $updateUrl = baseUrl('services_management/edit_quiz.php?updateId=' . $quiz_id . "&quiz_title=" . urlencode($quiz_title) . "&quiz_description=" . urlencode($quiz_description) . "&quiz_image=" . $quiz_image . "&question_limit=" . $question_limit . "&Bench_mark_point=" . $Bench_mark_point);
                                            $updateUrl .= "&quiz_status=" . $quiz_status . "&quiz_category=" . $_REQUEST['quiz_category_id'] . "&quiz_charge=$charging_amount&start_date=$quiz_start_time&end_date=$quiz_end_time";
                                            $updated_by = !empty($row->updated_by) ? $row->updated_by : "";
                                            $updated_at = longDateHuman($row->updated_at, 'date_time');
                                            $createdBy = !empty($row->created_by) ? $row->created_by : "";
                                            $created = longDateHuman($row->created_at, 'date_time');

                                            $quizEndUrl = baseUrl('content_management/push_quiz_score.php?quiz_id=' . $quiz_id);
                                            $quizEndUrl .= "&jsonData=" . urlencode(json_encode($row));
                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $quiz_title; ?></a>
                                                </td>
                                                <td><img src=" <?php echo $quiz_image; ?> " width="40" height="40"/>
                                                </td>
                                                <td><?php echo $quiz_description; ?></td>
                                                <td><?php echo $question_limit; ?></td>
                                                <td><?php echo $Bench_mark_point; ?></td>
                                                <td><?php echo $quiz_start_time; ?></td>
                                                <td><?php echo $quiz_end_time; ?></td>
                                                <td><?php echo $charging_amount; ?></td>
                                                <td>
                                                    <?php if (strtoupper($quiz_status) == 'ACTIVE') { ?>
                                                        <span class="label label-success"> <?php echo $quiz_status ?></span>
                                                    <?php } else if (strtoupper($quiz_status) == 'LIVE') { ?>
                                                        <span class="label label-primary"><?php echo $quiz_status ?></span>
                                                        <br></br>
                                                        <a title="Quiz End"
                                                           onclick="return confirm('Are you Sure??\nYou Want to Close This Quiz!');"
                                                           href="<?php echo $quizEndUrl; ?>">
                                                            <i class="fa fa-times-circle"
                                                               style="font-size:48px;color:red"></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <span class="label label-danger"><?php echo $quiz_status ?></span>
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

    <!--   <script type="text/javascript">
           $(document).ready(function () {
               $('#my_dynamic_table').dataTable({
                   "aaSorting": [[4, "desc"]]
               });
           });
       </script>-->
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

        function getCategory(sel) {

            var x = 0;
            x = sel.value;
            // alert(x);
            <?php  $uri = PROJECT_BASE_PATH . "/services_management/manage_quiz.php?quiz_category_id=";?>
            window.location.replace('<?php echo $uri;?>' + x);
        }

    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>