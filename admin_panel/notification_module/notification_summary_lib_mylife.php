<?php

$pageTitle = "Notification Summary";

$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

$condition = "?abc=abc";
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    $_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

if (isset($_REQUEST['services']) && $_REQUEST['services'] <> '') {
	//$services = str_replace("'", "", $_REQUEST['services']);
    $condition .= "&services=" . $services;
    $_SESSION['successMsg'] .= " Service Name $_REQUEST[services]";
    $serviceSelected = true;
}
//print_r($notificationSummaryUrl.$condition);exit;

$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
$notificationSummary = json_decode(file_get_contents($notificationSummaryUrl . $condition), false);


//echo $notificationSummaryUrl . $condition;;
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

                                            <form action="" id="filter_form">

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
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-danger btn-block btn-sm close_modal">
                                                        Clear Filter
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
                                        <th width="10%">Text</th>
                                        <th width="5%">Image</th>
                                        <th width="10%">Audio</th>
                                        <th width="10%">Video</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">WriteTime</th>
                                        <th width="10%">SentTime</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //print_r($notificationSummary) ;
                                    if (!empty($notificationSummary)) { ?>
                                        <?php $sl = 0;
                                        foreach ($notificationSummary as $key => $row) {

                                            $msisdn = !empty($row->MSISDN) ? $row->MSISDN : "";
                                            $text = !empty($row->SMSText) ? $row->SMSText : "";
                                            $image = !empty($row->image_path) ? $row->image_path : "";
                                            $audio = !empty($row->audio_path) ? $row->audio_path : "";
                                            $video = !empty($row->video_path) ? $row->video_path : "";
                                            $status = !empty($row->Status) ? $row->Status : "";
                                            $writeTime = !empty($row->ActivationDate) ? $row->ActivationDate : "";
                                            $sentTime = !empty($row->DeliveryTime) ? $row->DeliveryTime : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $sl + 1; ?></td>

                                                <td>
                                                    <?php echo $msisdn; ?>
                                                </td>
                                                <td>
                                                    <?php echo $text; ?>
                                                </td>
                                                <td>
                                                    <?php echo $image; ?>
                                                </td>
                                                <td>
                                                    <?php echo $audio; ?>
                                                </td>
                                                <td>
                                                    <?php echo $video; ?>
                                                </td>
                                                <td>
                                                    <?php echo $status; ?>
                                                </td>
                                                <td>
                                                    <?php echo $writeTime; ?>
                                                </td>
                                                <td>
                                                    <?php echo $sentTime; ?>
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

            $(".close_modal").on("click", function () {
                window.location = window.location.href.split("?")[0];
            });

            $('#my_dynamic_table').dataTable({
                "aaSorting": [[7, "asc"]]
            });

            //code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                //   var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $notificationSummaryExprtUrl;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                //var services = '<?php if (isset($_REQUEST['services'])) echo $_REQUEST['services']; ?>';
                var services = $("#services").val();


                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&services=" + services);

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