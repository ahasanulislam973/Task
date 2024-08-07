<?php
session_start();
require_once '../config/config.php';
require_once '../config/service_config.php';
//require_once '../lib/functions.php';

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

$pageTitle = "New Old User";
$tabActive = "newspaper_reporting";
$subTabActive = "new_old_user";
$mailSubject = "Newspaper At Home/Office Log";
//$condition = '';
$_SESSION['successMsg'] = '';

$condition = '?abc=abc';
if (isset($_REQUEST['user_category'])) {
    $condition .= "&user_category=" . $_REQUEST['user_category'];
}

//$newOldUserReportingUrl = 'https://botservice.dotlines.com.sg/bot_service_api/service_info_modify/newOldUserList.php';
$newOldUserReporting = json_decode(file_get_contents($newOldUserReportingUrl . $condition));

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

                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                        </header>

                        <div class="panel-body">
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <label for="role">Choose User Category<span class="text-danger">*</span></label>
                                <select name="user_category" id="user_category" class="form-control smart_select ">

                                    <option disabled selected value> -- Select a Category --</option>
                                    <option value="new">New User</option>
                                    <option value="old">Old User</option>
                                    <?php if (isset($_REQUEST['user_category'])) { ?> selected="selected" <?php } ?>

                                </select>
                            </div>
                            <div id="btnDiv" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <button id="show_data" name="show_data" class="btn btn-sm btn-info">
                                    Show Data
                                </button>

                                <button id="export_data" name="export_data" class="btn btn-sm btn-success">
                                    Export Data
                                </button>

                                </span>
                            </div>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Person Name</th>
                                        <th width="10%">MobileNo</th>
                                        <th width="10%">Order Address</th>
                                        <th width="10%">Registration Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($newOldUserReporting)) { ?>
                                        <?php
                                        foreach ($newOldUserReporting as $key => $row) {

                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            // $msisdnForPayment = !empty($row->msisdn_payment) ? $row->msisdn_payment : "";
                                            $personName = !empty($row->person_name) ? $row->person_name : "";
                                            $orderAddress = !empty($row->address) ? $row->address : "";
                                            $regDate = !empty($row->created_at) ? $row->created_at : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $personName; ?>
                                                </td>
                                                <td>
                                                    <?php echo $msisdn; ?>
                                                </td>
                                                <!--<td>
                                                    <?php /*echo $msisdnForPayment; */ ?>
                                                </td>-->
                                                <td>
                                                    <?php echo $orderAddress; ?>
                                                </td>
                                                <td>
                                                    <?php echo longDateHuman($regDate, 'date_time'); ?>
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

                var user_category = document.getElementById('user_category').value;
                //alert(user_category);
                if (user_category == '') {
                    alert('Please select a Category ')
                    return;
                }

                var baseUrl = '<?php echo $newOldUserExcelReportUrl;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';

                window.open(baseUrl + '?first_date=' + first_date + "&last_date=" + last_date + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&user_category=" + user_category);

            });

            //code after Show Button Click
            $('#btnDiv').on('click', '#show_data', function () {

                var user_category = document.getElementById('user_category').value;
                //  alert(user_category);
                if (user_category == '') {
                    alert('Please select a Category ')
                    return;
                }
                <?php  $uri = PROJECT_BASE_PATH . "/newspaper_reporting/new_old_user.php?user_category=";?>
                window.location.replace('<?php echo $uri;?>' + user_category);

            });

            $('#btnDiv').on('click', '#export_data_send_mail', function () {

                var user_category = document.getElementById('user_category').value;
                //alert(user_category);
                if (user_category == '') {
                    alert('Please select a Category ')
                    return;
                }

                var base_url = '<?php echo $himalayanLogExportDataSendMail; ?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();

                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                var purpose = 'newspaper_at_home_office';

                var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&purpose=" + purpose + "&user_category=" + user_category);

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