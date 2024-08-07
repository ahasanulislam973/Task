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

$pageTitle = "Quiz Log";
$tabActive = "quiz_reporting";
$subTabActive = "quiz_log";
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

//$quizName = json_decode(file_get_contents($quizNameList . "?quiz_category_id=1"));

$condition = "?abc=abc";

if (isset($_REQUEST['msisdn']) && $_REQUEST['msisdn'] <> '') {
    $condition .= "&msisdn=" . $_REQUEST['msisdn'];
    $_SESSION['successMsg'] = "Msisdn: $_REQUEST[msisdn] ";
}
if (isset($_REQUEST['category_id']) && $_REQUEST['category_id'] <> '') {
    $condition .= "&quiz_category_id=" . $_REQUEST['category_id'];
   
}
if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] <> '') {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
    $serviceSelected = true;
}

if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

//echo $quizLogUrl . $condition;

$quizLog = json_decode(file_get_contents($quizLogUrl . $condition));

include_once INCLUDE_DIR . 'header.php';
?>
    <!--dynamic data table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

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
                            <span id="btnDiv" class="pull-left">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>
                            <span class="pull-right">
                            <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                               Filter
                            </a>
                            </span>
                            <?php include 'quizFilterModal.php'; ?>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Quiz Category</th>
                                        <th width="10%">Quiz ID</th>
                                        <th width="10%">Quiz Title</th>
                                        <th width="10%">MSISDN</th>
                                        <th width="10%">Question ID</th>
                                        <th width="10%">Question</th>
                                        <th width="10%">User Answer</th>
                                        <th width="10%">Correct Answer</th>
                                        <th width="10%">Answer Status</th>
                                        <th width="10%">Score</th>
                                        <th width="10%">Date-Time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizLog)) { ?>
                                        <?php
                                        foreach ($quizLog as $key => $row) {

                                            $quizCategoryName = !empty($row->quiz_category_name) ? $row->quiz_category_name : "";
                                            $quizId = !empty($row->quiz_id) ? $row->quiz_id : "";
                                            $quizTitle = !empty($row->quiz_title) ? $row->quiz_title : "";
                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            $questionId = !empty($row->question_id) ? $row->question_id : "";
                                            $question = !empty($row->question) ? $row->question : "";
                                            $userAns = !empty($row->user_ans) ? $row->user_ans : "";
                                            $correctAns = !empty($row->correct_ans) ? $row->correct_ans : "";
                                            $answerStatus = !empty($row->answer_status) ? $row->answer_status : "";
                                            $score = !empty($row->Score) ? $row->Score : "";
                                            $startTime = !empty($row->start_time) ? $row->start_time : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $quizCategoryName; ?>
                                                </td>
                                                <td>
                                                    <?php echo $quizId; ?>
                                                </td>
                                                <td>
                                                    <?php echo $quizTitle; ?>
                                                </td>

                                                <td>
                                                    <?php echo $msisdn; ?>
                                                </td>
                                                <td>
                                                    <?php echo $questionId; ?>
                                                </td>
                                                <td>
                                                    <?php echo $question; ?>
                                                </td>

                                                <td>
                                                    <?php echo $userAns; ?>
                                                </td>
                                                <td>
                                                    <?php echo $correctAns; ?>
                                                </td>
                                                <td>
                                                    <?php if (strtoupper($answerStatus) == 'CORRECT') { ?>
                                                        <span class="label label-success"> <?php echo $answerStatus ?></span>
                                                    <?php } else { ?>
                                                        <span class="label label-danger"><?php echo $answerStatus ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php echo $score; ?>
                                                </td>
                                                <td>
                                                    <?php echo $startTime; ?>
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

            //code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                // var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $quizLogExprtUrl;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                // var quiz_id = $("#quiz_id").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
				 if (quiz_id == '') {
                    alert('Please select a Category ')
                    return;
                }


                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);

            });
        });


        $(function () {

            $('input[name="daterange"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

                var first_date = document.getElementById('first_date');
                first_date.value = picker.startDate.format('YYYY-MM-DD');
                var last_date = document.getElementById('last_date');
                last_date.value = picker.endDate.format('YYYY-MM-DD');
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });

    </script>

    <!--Dynamic Data Table-->
    <script type="text/javascript" language="javascript"
            src="<?php echo baseUrl('assets/modules/advanced-datatable/media/js/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.js'); ?>"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>