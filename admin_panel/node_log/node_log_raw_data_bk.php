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

$pageTitle = "Node Wise User Logs";
$tabActive = "node_log";
$subTabActive = "node_log_raw_data";
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

$mailSubject = $pageTitle;

$condition = "?abc=abc";

if (isset($_REQUEST['messenger_id']) && $_REQUEST['messenger_id'] <> '') {
    $condition .= "&messenger_id=" . $_REQUEST['messenger_id'];
    $serviceSelected = true;
}
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

$nodeLogRawData = json_decode(file_get_contents($nodeLogRawDataUrl . $condition));


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
                        <div class="alert alert-info">
                            <strong>Alert!</strong> <br>
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
                            <button id="export_data_send_mail" name="export_data_send_mail"
                                    class="btn btn-sm btn-danger">
                              Export Data & Send Mail
                            </button>
                            <a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                               Filter
                            </a>
                            </span>

                            <div class="clearfix"></div>
                            <div class="clearfix"></div>

                            <?php include 'quizFilterModal.php'; ?>
                            <!--<div class="clearfix"></div>-->

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="6%">User MessengerID</th>
                                        <th width="20%">Landing Node</th>
                                        <th width="10%">Node Reach Time</th>
                                        <!--<th width="15%">FB Page ID</th>-->
                                        <!--<th width="15%">Message ID</th>-->
                                        <!--<th width="20%">Destination Node Name</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($nodeLogRawData)) { ?>
                                        <?php
                                        foreach ($nodeLogRawData as $key => $row) {

                                            // $pageId = !empty($row->page_id) ? $row->page_id : "";
                                            // $msg_id = !empty($row->msg_id) ? $row->msg_id : "";
                                            // $destinationNode = !empty($row->destinationNode) ? $row->destinationNode : "";

                                            $messenger_id = !empty($row->messenger_id) ? $row->messenger_id : "";
                                            $sourceNode = !empty($row->sourceNode) ? $row->sourceNode : "";
                                            $event_time = !empty($row->event_time) ? longDateHuman($row->event_time, 'datetime') : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $messenger_id; ?></td>
                                                <td><?php echo $sourceNode; ?></td>
                                                <td><?php echo $event_time; ?></td>

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
                var base_url = '<?php echo $ondemandLogUrl;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id);

            });

            $('#btnDiv').on('click', '#export_data_send_mail', function () {

                var base_url = '<?php echo $exportDatanSendMail;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';
                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>');

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