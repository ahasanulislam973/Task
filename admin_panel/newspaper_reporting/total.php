<?php
session_start();
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

$pageTitle = "Total Log";
$tabActive = "newspaper_reporting";
$subTabActive = "total";
$condition = '';
$serviceSelected = false;
$mailSubject = "Total Log";

$condition = "?abc=abc&";

$total = json_decode(file_get_contents($totalLogUrl . $condition));
//print_r($total);exit;

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
                            </span> -->

                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                    <td colspan="4" align="center"> <b>TOTAL</b></td>
                                       
                                    </tr>
                                    <tr class="">
                                        <th width="25%">This Week</th>
                                        <th width="25%">Past Week</th>
                                        <th width="25%">This Month</th>
                                        <th width="25%">Past Month</th>

                                     </tr>

                                    </thead>
                                    <tbody>
                                    <?php if (!empty($total)) { ?>
                                        <?php
                                        foreach ($total as $key => $row) {
                                            $thisWeekTotal = !empty($row->thisWeekTotal) ? $row->thisWeekTotal : 0;
                                            $pastWeekTotal = !empty($row->pastWeekTotal) ? $row->pastWeekTotal : 0;
                                            $thisMonthTotal = !empty($row->thisMonthTotal) ? $row->thisMonthTotal : 0;
                                            $pastMonthTotal = !empty($row->pastMonthTotal) ? $row->pastMonthTotal : 0;
                                          
                                            ?>
                                            <tr class="gradeX">
                                              
                                                <td>
                                                    <?php echo $thisWeekTotal; ?>
                                                </td><td>

                                                    <?php echo $pastWeekTotal; ?>
                                                </td>
                                                <td>
                                                    <?php echo $thisMonthTotal; ?>
                                                </td><td>

                                                    <?php echo $pastMonthTotal; ?>
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

                var baseUrl = '<?php echo $serviceUsedByUserLogExportUrl;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                var purpose = 'SERVICE_USED_BY_USER';
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