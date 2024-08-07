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

$pageTitle = "Quiz Rank List";
$tabActive = "trivia_quiz";
$subTabActive = "trivia_quiz_rank_list";
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

//$quizName = json_decode(file_get_contents($quizNameList . "?quiz_category_id=1"));

$condition = "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];


if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] <> '') {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
    $serviceSelected = true;
}
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

//echo $quizRankListUrl . $condition;

$quizRankList = json_decode(file_get_contents($quizRankListUrl . $condition));

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
                            <?php include 'quizRankFilterModal.php'; ?>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">MSISDN</th>
                                        <th width="10%">Rank</th>
                                        <th width="10%">Score</th>
                                        <th width="10%">Total Played</th>
                                        <th width="10%">Right Answer</th>
                                        <th width="10%">Wrong Answer</th>
                                        <th width="10%">No Answer</th>
                                        <th width="10%">Time Taken</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizRankList)) { ?>
                                        <?php
                                        foreach ($quizRankList as $key => $row) {

                                            $userRank = !empty($row->rank) ? $row->rank : "";
                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            $score= !empty($row->score) ? $row->score : 0;
                                            $totalPlayed = !empty($row->played) ? $row->played : 0;
                                            $correctAns = !empty($row->correct_ans) ? $row->correct_ans : 0;
                                            $wrongAns = !empty($row->wrong_ans) ? $row->wrong_ans : 0;
                                            $noAns = !empty($row->no_ans) ? $row->no_ans : 0;
                                            $takenTime = !empty($row->time_required) ? $row->time_required : 0;
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $msisdn; ?>
                                                </td>
                                                <td>
                                                    <?php echo $userRank; ?>
                                                </td>
                                                <td>
                                                    <?php echo $score; ?>
                                                </td>

                                                <td>
                                                    <?php echo $totalPlayed; ?>
                                                </td>
                                                <td>
                                                    <?php echo $correctAns; ?>
                                                </td>
                                                <td>
                                                    <?php echo $wrongAns; ?>
                                                </td>

                                                <td>
                                                    <?php echo $noAns; ?>
                                                </td>
                                                <td>
                                                    <?php echo $takenTime; ?>
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
                var base_url = '<?php echo $quizRankListExprtUrl;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                // var quiz_id = $("#quiz_id").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';

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