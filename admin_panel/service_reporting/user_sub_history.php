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

$pageTitle = "User Subscription History";
$tabActive = "service_reporting";
$subTabActive = "user_sub_history";

$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

$condition = "?abc=abc";

if (isset($_REQUEST['msisdn']) && $_REQUEST['msisdn'] <> '') {
    $condition .= "&msisdn=" . $_REQUEST['msisdn'];
    $_SESSION['successMsg'] = "Msisdn: $_REQUEST[msisdn] ";
}

if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

if (isset($_REQUEST['services']) && $_REQUEST['services'] <> '') {
    $condition .= "&services=" . $_REQUEST['services'];
    $_SESSION['successMsg'] .= " Service Name $_REQUEST[services]";
    $serviceSelected = true;
}

$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
$userSubscriptionHistory = json_decode(file_get_contents($userSubscriptionHistoryUrl . $condition));
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
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                 id="myModal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Date Range For Filter</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="#">

                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <label class="control-label ">
                                                        Set Date Range *</label>

                                                    <input class="form-control" type="text"
                                                           name="daterange" autocomplete="off"/>

                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="clearfix"></div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <label class="control-label ">
                                                        Service Name</label>

                                                    <select class="form-control smart_select" name="services"
                                                            id="services">
                                                        <?php foreach ($ReportingServiceName as $key => $val) { ?>
                                                            <option value="<?php echo $key ?>"
                                                                <?php if (isset($_REQUEST['services']) && $_REQUEST['services'] == $key) { ?> selected="selected" <?php } ?>>
                                                                <?php echo $val; ?>
                                                            </option>
                                                        <?php } ?>

                                                    </select>

                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label for="maisdn">MSISDN </label>
                                                    <input class="form-control" type="number" id="msisdn" name="msisdn"
                                                           value="<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>">
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
                                                    <a href="user_sub_history.php" <span
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
                                        <th width="5%">SL</th>
                                        <th width="10%">MSISDN</th>
                                        <th width="10%">Service</th>
                                        <th width="10%">Event Type</th>
                                        <th width="10%">Event Date-time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($userSubscriptionHistory)) { ?>
                                        <?php $sl = 0;
                                        foreach ($userSubscriptionHistory as $key => $row) {

                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            $ServiceName = !empty($row->Service_name) ? $row->Service_name : "";
                                            $EventType = !empty($row->event_type) ? $row->event_type : "";
                                            $lastUpdate = !empty($row->event_time) ? $row->event_time : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $sl + 1; ?></td>

                                                <td>
                                                    <?php echo $msisdn; ?>
                                                </td>

                                                <td>
                                                    <?php echo $ServiceName; ?>
                                                </td>
                                                <td>
                                                    <?php if (strtoupper($EventType) == 'REGISTERED') { ?>
                                                        <span class="label label-success"> <?php echo $EventType ?></span>
                                                    <?php } else if (strtoupper($EventType) == 'RENEWED SUCCESSFULLY') { ?>
                                                        <span class="label label-info"><?php echo $EventType ?></span>
                                                    <?php } else { ?>
                                                        <span class="label label-danger"><?php echo $EventType ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php echo $lastUpdate; ?>
                                                </td>

                                            </tr>
                                            <?php $sl++;
                                        } ?>
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

             //   var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $subHistoryExprtUrl;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var services = $("#services").val();
                var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';


                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&services=" + services + "&msisdn=" + msisdn);

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