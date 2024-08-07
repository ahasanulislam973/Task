<?php
session_start();
// require_once '../config/config.php';
require_once '../lib/functions.php';
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

/*print "<pre>";
print_r(API_BASE_PATH);
print_r('<br>');
print_r($himalayanLogExportUrl);
print "</pre>";
exit;*/

$pageTitle = "Newspaper @ Home/Office Log";
$tabActive = "newspaper_reporting";
$subTabActive = "newspaper_at_home_office";
$condition = '';
// $_SESSION['successMsg'] = '';
$serviceSelected = false;
$mailSubject = "Newspaper At Home/Office Log";

//$quizName = json_decode(file_get_contents($quizNameList . "?quiz_category_id=1"));

/*$condition = "?abc=abc";

if (isset($_REQUEST['msisdn']) && $_REQUEST['msisdn'] <> '') {
    $condition .= "&msisdn=" . $_REQUEST['msisdn'];
    $_SESSION['successMsg'] = "Msisdn: $_REQUEST[msisdn] ";
}
if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] <> '') {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
    $serviceSelected = true;
}
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}*/


// SetDBInfo($HT_Server, $HT_Database, $HT_UserID, $HT_Password, $HT_dbtype);

SetDBInfo($service_Server, $service_Database, $service_UserID, $service_Password, $service_dbtype);
$cn = connectDB();
$qry = "SELECT `profile_id`, `msisdn`, `person_name`, `address` as order_address, `created_at`, updated_at, status, visit_date FROM `HimalayanUserProfile` ORDER BY updated_at DESC";
$rs = Sql_exec($cn, $qry);
$resultArr = array();
if (Sql_Num_Rows($rs) > 0) {
    while ($row = mysqli_fetch_object($rs)) {
        $resultArr[] = $row;
    }
}
ClosedDBConnection($cn);

$newspaperAtHomeOffice = $resultArr;

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
                            <span id="btnDiv" class="pull-left">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>

                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">#SL</th>
                                        <th width="10%">Person Name</th>
                                        <th width="10%">Mobile No.</th>
                                        <th width="10%">Order Address</th>
                                        <th width="5%">Status</th>
                                        <th width="10%">Registration Date</th>
                                        <th width="10%">Visit Date</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($newspaperAtHomeOffice)) { ?>
                                        <?php
                                        foreach ($newspaperAtHomeOffice as $key => $row) {
                                            $profileId = !empty($row->profile_id) ? $row->profile_id : NULL;
                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            $personName = !empty($row->person_name) ? $row->person_name : "";
                                            $orderAddress = !empty($row->order_address) ? $row->order_address : "";
                                            $userStatus = !empty($row->status) ? $row->status : "";
                                            $status = !empty($row->status) ? $row->status : "";
                                            $visitDate = !empty($row->visit_date) ? longDateHuman($row->visit_date, 'date') : "";
                                            $regDate = !empty($row->updated_at) ? longDateHuman($row->updated_at, 'date_time') : "";
                                            $updateUrl = baseUrl("newspaper_reporting/update_newspaper_at_home_office.php?updateId=" . $profileId);
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td><?php echo $personName; ?></td>

                                                <td><?php echo $msisdn; ?></td>
                                                <td><?php echo $orderAddress; ?></td>

                                                <td>
                                                    <?php
                                                    if ($status == 'Subscribed') {
                                                        echo '<span class="label label-success">Subscribed</span>';
                                                    } else {
                                                        echo '<span class="action label label-danger">Pending</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <td><?php echo $regDate; ?></td>
                                                <td><?php echo $visitDate; ?></td>

                                                <td>
                                                    <a class="btn btn-warning btn-xs" title="Update"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i>
                                                        Update</a>
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