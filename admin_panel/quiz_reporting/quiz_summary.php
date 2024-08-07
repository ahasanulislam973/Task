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

$pageTitle = "Quiz Summary";
$tabActive = "quiz_reporting";
$subTabActive = "quiz_summary";

$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

//$quizName = json_decode(file_get_contents($quizNameList . "?quiz_category_id=1"));

$condition = "?abc=abc";


if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] <> '') {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
    $serviceSelected = true;
}
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}


$quizSummary= json_decode(file_get_contents($quizSummaryUrl . $condition));
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
                            <span id="btnDiv" class="pull-left">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>
                        <span class="pull-right">
                            <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                               Set Filter
                            </a>
                            </span>

                        <?php include 'quizFilterModal.php'; ?>
                        <div class="clearfix"></div>


                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Date</th>
                                        <th width="5%">Unique User</th>
                                        <th width="10%">Quiz Played</th>
                                        <th width="10%">Revenue(TTL)</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizSummary)) { ?>
                                        <?php
                                        foreach ($quizSummary as $key => $row) {

                                            $date = !empty($row->date) ? $row->date : "";
                                            $uniqueUser = !empty($row->unique_user) ? $row->unique_user : "";
                                            $quizPlayed = !empty($row->quiz_played) ? $row->quiz_played : "";
                                            $revenue = !empty($row->revenue) ? $row->revenue : "";


                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $date; ?>
                                                </td>
                                                <td>
                                                    <?php echo $uniqueUser; ?>
                                                </td>
                                                <td>
                                                    <?php echo $quizPlayed; ?>
                                                </td>

                                                <td>
                                                    <?php echo $revenue; ?>
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
                "aaSorting": [[5, "asc"]]
            });
        });

        //code after Export Button Click
        $('#btnDiv').on('click', '#export_data', function () {

           // var base_url = 'https://' + window.location.host + '/BOT/export_data/';
            var base_url = '<?php echo $quizSummaryExprtUrl;?>';


            var first_date = $("#first_date").val();
            var last_date = $("#last_date").val();
            //  var quiz_id = $("#quiz_id").val();//category_id
            var category_id = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; ?>';
            var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';


            window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&quiz_id=" + quiz_id + "&category_id=" + category_id);

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