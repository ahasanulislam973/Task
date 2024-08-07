<?php

/*print "<pre>";
print_r(INCLUDE_DIR);
print "</pre>";
exit;*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $_SESSION['successMsg'] = "Filter Applied From $_REQUEST[first_date] To $_REQUEST[last_date]";
    // header('Location:' . $redirectUrl);
}
if (isset($_REQUEST['services']) && $_REQUEST['services'] <> '') {
    $condition .= "&services=" . $_REQUEST['services'];
    $_SESSION['successMsg'] .= " Service Name $_REQUEST[services]";
    $serviceSelected = true;
}

$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
$contentPushHistory = json_decode(file_get_contents($contentPushHistoryUrl_Istishon . $condition));

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
                               Set Filter
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

                                            <form action="">

                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label text-danger">
                                                        Set Date Range *</label>

                                                    <input class="form-control" type="text"
                                                           name="daterange" autocomplete="off"/>

                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label text-danger">
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
                                                <div class="clearfix"></div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label for="maisdn">FB MESSENGER ID </label>
                                                    <input class="form-control" type="number" id="msisdn" name="msisdn"
                                                           value="<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>">
                                                </div>
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
                                                    <a href="content_delivery_report_lib_istishon.php" <span
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
                                        <th width="10%">FB MESSENGER ID</th>
                                        <th width="10%">Service</th>
                                        <th width="10%">Content ID</th>
                                        <th width="10%">Sent Time</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Check</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($contentPushHistory)) {

                                        foreach ($contentPushHistory as $key => $row) {

                                            $MESSENGER_ID = !empty($row->MESSENGER_ID) ? $row->MESSENGER_ID : "";
                                            $ServiceName = !empty($row->Service) ? $row->Service : "";
                                            $ContentId = !empty($row->Content_ID) ? $row->Content_ID : "";
                                            $sentTime = !empty($row->Sent_Time) ? $row->Sent_Time : "";
                                            $status = !empty($row->Status) ? $row->Status : "";
                                            $checkStatus = !empty($row->Check) ? $row->Check : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo $MESSENGER_ID; ?>
                                                </td>
                                                <td>
                                                    <?php echo $ServiceName; ?>
                                                </td>

                                                <td>
                                                    <?php echo $ContentId; ?>
                                                </td>

                                                <td>
                                                    <?php echo $sentTime; ?>
                                                </td>

                                                <td>
                                                    <?php if (strtoupper($status) == 'SENT') { ?>
                                                        <span class="label label-success"> <?php echo $status ?></span>
                                                    <?php } else { ?>
                                                        <span class="label label-danger"><?php echo $status ?></span>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php if ($checkStatus == 'YES') { ?>
                                                        <span class="text-success" title="Checked">
                                                            <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                                                        </span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="text-danger" title="Not Checked">
                                                            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                                                        </span>
                                                        <?php
                                                    }
                                                    ?>
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

                //   var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $serviceContentPushExprtUrl_Istishon;?>';

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