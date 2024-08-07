<?php
session_start();
// require_once '../config/config.php';
require_once '../lib/functions.php';
require_once '../config/service_config.php';
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

/*print "<pre>";
print_r(API_BASE_PATH);
print_r('<br>');
print_r($himalayanLogExportUrl);
print "</pre>";
exit;*/

$pageTitle = "Customer Care Queries and Answer Push";
$tabActive = "fb_queries";
//$subTabActive = "newspaper_at_home_office";
$condition = '';
// $_SESSION['successMsg'] = '';
$serviceSelected = false;
$mailSubject = "Customer Care Queries";

SetDBInfo($BRef_Server, $BRef_Database, $BRef_UserID, $BRef_Password, $BRef_dbtype);
$cn = connectDB();
$qry = "SELECT `id`,`facebook_id`, `query`, `username`, `profilePic`,`response`, is_sent, read_status, created_at ,updated_at
FROM $tabActive ORDER BY updated_at DESC";
$rs = Sql_exec($cn, $qry);
$resultArr = array();

if (Sql_Num_Rows($rs) > 0) {
    while ($row = mysqli_fetch_object($rs)) {
        $resultArr[] = $row;
    }
}
ClosedDBConnection($cn);

$newspaperAtHomeOffice = $resultArr;
$customerCareQuery = $resultArr;

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
                            <!--<span id="btnDiv" class="pull-left">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>-->

                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">Id</th>
                                        <th width="10%">FB Id</th>
                                        <th width="10%">Query</th>
                                        <<!--th width="10%">User Name</th>-->
                                        <!--<th width="5%">profile Pic</th>-->
                                        <th width="10%">Answer</th>
                                        <!--    <th width="2%">is_sent</th>
                                            <th width="2%">Read Status</th>-->
                                        <th width="10%">Created At</th>
                                        <th width="10%">Updated At</th>
                                        <th width="10%">Answer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($customerCareQuery)) { ?>
                                        <?php
                                        foreach ($customerCareQuery as $key => $row) {
                                            $Id = !empty($row->id) ? $row->id : NULL;
                                            $profileId = !empty($row->facebook_id) ? $row->facebook_id : NULL;
                                            $query = !empty($row->query) ? $row->query : "";
                                            $username = !empty($row->username) ? $row->username : "";
                                            $profilePic = !empty($row->profilePic) ? $row->profilePic : "";
                                            $response = !empty($row->response) ? $row->response : "";
                                            $is_sent = $row->is_sent;
                                            $read_status = $row->read_status;
                                            $created_at = !empty($row->created_at) ? longDateHuman($row->created_at, 'date_time') : "";
                                            $updated_at = !empty($row->updated_at) ? longDateHuman($row->updated_at, 'date_time') : "";
                                            $updateUrl = baseUrl("bkash_referral/post_query_answer_edit.php?updateId=" . $Id);
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $Id; ?></td>
                                                <td><?php echo $profileId; ?></td>
                                                <td><?php echo $query; ?></td>
                                                <!--<td><?php /*echo $username; */?></td>-->
                                                <!--<td><?php /*echo $profilePic; */?></td>-->
                                                <td><?php echo $response; ?></td>
                                                <!--  <td><?php /*echo $is_sent; */?></td>
                                                <td><?php /*echo $read_status; */?></td>-->
                                                <td><?php echo $created_at; ?></td>
                                                <td><?php echo $updated_at; ?></td>

                                                <td>
                                                    <a class="btn btn-warning btn-xs" title="response"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i>
                                                        Answer</a>
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
            /*$('#my_dynamic_table').dataTable({
                "aaSorting": [[4, "desc"]]
            });*/

            $('#my_dynamic_table').DataTable({
                "order": [[0, "desc"]], //or asc
                // "columnDefs" : [{"targets":3, "type":"date-eu"}],
            });

            //code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                var baseUrl = '<?php echo $himalayanLogExportUrl;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                var purpose = 'newspaper_at_home_office';
                window.open(baseUrl + '?first_date=' + first_date + "&last_date=" + last_date + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&purpose=" + purpose);

            });

            $('#btnDiv').on('click', '#_export_data_send_mail_', function () {

                var base_url = '<?php echo $himalayanLogExportDataSendMail; ?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();

                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                var purpose = 'newspaper_at_home_office';

                var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&purpose=" + purpose);

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