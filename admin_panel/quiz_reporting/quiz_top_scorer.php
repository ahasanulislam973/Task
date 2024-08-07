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

$pageTitle = "Top 5 scorer in last 2 hours";
$tabActive = "quiz_reporting";
$subTabActive = "quiz_top_scorer";
$topScorer = json_decode(file_get_contents($topScorerUrl));
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
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Quiz Category</th>
                                        <th width="10%">Quiz Title</th>
                                        <th width="10%">MSISDN</th>
                                        <th width="10%">Start Time</th>
                                        <th width="10%">End Time</th>
                                        <th width="10%">Duration</th>
                                        <th width="10%">Duration</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($topScorer)) { ?>
                                        <?php
                                        foreach ($topScorer as $key => $row) {

                                            $quizCategoryName = !empty($row->quiz_category_name) ? $row->quiz_category_name : "";
                                            $quizTitle = !empty($row->quiz_title) ? $row->quiz_title : "";
                                            $MSISDN = !empty($row->msisdn) ? $row->msisdn : "";
                                            $startTime = !empty($row->start_time) ? $row->start_time : "";
                                            $endTime = !empty($row->end_time) ? $row->end_time : "";
                                            $duration = !empty($row->duration) ? $row->duration : "";
                                            $score = !empty($row->Score) ? $row->Score : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $quizCategoryName; ?>
                                                </td>
                                                <td>
                                                    <?php echo $quizTitle; ?>
                                                </td>

                                                <td>
                                                    <?php echo $MSISDN; ?>
                                                </td>

                                                <td>
                                                    <?php echo $startTime; ?>
                                                </td>

                                                <td>
                                                    <?php echo $endTime; ?>
                                                </td>
                                                <td>
                                                    <?php echo $duration; ?>
                                                </td>
                                                <td>
                                                    <?php echo $score; ?>
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