<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../config/config.php';
require_once '../config/service_config.php';
require_once '../../bot_service_api/lib/functions.php';


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
//kc
$organization_id=$_SESSION['admin_login_info']['organization_id'];
SetDBInfo($service_Server, $quiz_Database, $service_UserID, $service_Password, $service_dbtype);
 
// connect db
$cn = connectDB();

mysqli_query($cn, 'SET CHARACTER SET utf8');
mysqli_query($cn, "SET SESSION collation_connection ='utf8_general_ci'");

$qry = "SELECT	* FROM `quiz_category` WHERE organization_id=$organization_id AND quiz_type='poll' LIMIT 1";
$rs = Sql_exec($cn, $qry);

while ($row = Sql_fetch_assoc_array($rs)) {
    set_time_limit(0);
    $quiz_category_id = $row['quiz_category_id'];
}

$qry="SELECT * FROM `quiz` WHERE quiz_category_id=$quiz_category_id LIMIT 1";
$rs = Sql_exec($cn, $qry);
while ($row = Sql_fetch_assoc_array($rs)) {
    set_time_limit(0);
    $quiz_id = $row['quiz_id'];
}

ClosedDBConnection($cn);
//ClosedDBConnection();
//kc end

$pageTitle = "Voting POLL";
$tabActive = "service_reporting";
$subTabActive = "voting_poll";
$mailSubject = 'Voting Poll Log';
$votingPollId = $quiz_id;
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

// $quizName = json_decode(file_get_contents($quizNameList . "?quiz_category_id=1"));

$condition ='';

if (isset($votingPollId) && $votingPollId <> '') {
    $condition .= "?quiz_id=" . $quiz_id;
    $condition .= "&quiz_category_id=" . $quiz_category_id;

}

if (isset($_REQUEST['msisdn']) && $_REQUEST['msisdn'] <> '') {
    $condition .= "&msisdn=" . $_REQUEST['msisdn'];
    $_SESSION['successMsg'] = "Msisdn: $_REQUEST[msisdn] ";
}
if (isset($_REQUEST['messenger_id']) && $_REQUEST['messenger_id'] <> '') {
    $condition .= "&messenger_id=" . $_REQUEST['messenger_id'];
    $_SESSION['successMsg'] = "messengerId: $_REQUEST[messenger_id] ";
}

/*if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] <> '') {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
    $serviceSelected = true;
}*/
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

//echo $votingPollLogUrl. $condition;

$quizLog = json_decode(file_get_contents($votingPollLogUrl . $condition));


/*print "<pre>";
print_r($quizLog);
print "</pre>";*/

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

                    <?php if (isset($_SESSION['successMsg']) && $_SESSION['successMsg'] != '') {
                        ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <br>
                            <?php
                            echo $_SESSION['successMsg'];
                            unset($_SESSION['successMsg']);
                            ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_SESSION['MAIL_SEND_MSG'])) {
                        ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <br>
                            <?php
                            echo $_SESSION['MAIL_SEND_MSG'];
                            unset($_SESSION['MAIL_SEND_MSG']);
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

                            <span class="pull-right">

                           <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                               Filter
                            </a>
                            </span>
                             <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                  id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> Filter Submission</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                         <form action="#">

                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label class="control-label ">
                                                    Set Date Range *</label>

                                                <input class="form-control" type="text"
                                                       name="daterange" autocomplete="off"/>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="question_id">Messenger ID</label>
                                                <input class="form-control" type="text" id="messenger_id"
                                                       name="messenger_id"
                                                       value="<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>">
                                            </div>
                                            <div class="clearfix"></div>

                                            <input type="hidden" id="first_date" name="first_date"
                                                   value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['first_date']; ?>">
                                            <input type="hidden" id="last_date" name="last_date"
                                                   value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['last_date']; ?>">
                                            <div class="clearfix"></div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <input type="submit" class="btn btn-info btn-block btn-sm"
                                                       name="filter" id="filter"
                                                       value="Apply Filter">
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <a href="voting_poll.php" <span
                                                        class="btn btn-danger btn-block btn-sm"> Clear Filter</span>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="4%">SL</th>
                                        <th width="10%">Messenger ID</th>
                                        <th width="15%">Question</th>
                                        <th width="6%">User Ans</th>
                                        <th width="6%">Start Time</th>
                                        <th width="6%">End Time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizLog)) { ?>
                                        <?php
                                        foreach ($quizLog as $key => $row) {

                                            $question = !empty($row->question) ? $row->question : "";
                                            $msngr_id = !empty($row->msngr_id) ? $row->msngr_id : "";
                                            $user_ans = !empty($row->user_ans) ? $row->user_ans : "";
                                            $start_time = !empty($row->start_time) ? $row->start_time : "";
                                            $end_time = !empty($row->end_time) ? $row->end_time : "";

                                            ?>
                                            <tr class="gradeX">

                                               <td><?php echo $key + 1; ?></td>


                                                <td>
                                                    <?php echo $msngr_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $question; ?>
                                                </td>

                                                <td>
                                                    <?php echo $user_ans; ?>
                                                </td>
                                                 <td>
                                                    <?php echo $start_time; ?>
                                                </td>

                                                <td>
                                                    <?php echo $end_time; ?>
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
                "aaSorting": [[0, "asc"]]
            });

            //code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                // var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $votingPollLExprtUrl__ProthomAlo;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; else echo $votingPollQuizId_ProthomAlo;?>';
                var quiz_category_id = '<?php if (isset($_REQUEST['quiz_category_id'])) echo $_REQUEST['quiz_category_id']; else echo $votingPollQuizCategoryId_ProthomAlo; ?>';

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&quiz_id=" + quiz_id + '&quiz_category_id=' + quiz_category_id);

            });

            $('#btnDiv').on('click', '#__export_data_send_mail', function () {

                var base_url = '<?php echo $quizLogExprtAndSendMail; ?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                // var quiz_id = '<?php /*if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id'];*/ ?>';
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; else echo $votingPollId; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);

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
