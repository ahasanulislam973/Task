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

$pageTitle = "Text Reply Report";
$tabActive = "service_reporting";
$subTabActive = "text_reply_report";
$mailSubject = "Newspaper At Home/Office Log";
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

/*
SetDBInfo($HT_Server, $HT_Database, $HT_UserID, $HT_Password, $HT_dbtype);
$cn = connectDB();
$qry = "SELECT `msisdn`, `msisdn_payment`, `person_name`, `address` as order_address, `created_at` FROM `UserProfile` ORDER BY created_at DESC";
$rs = Sql_exec($cn, $qry);
$resultArr = array();
if (Sql_Num_Rows($rs) > 0) {
    while ($row = mysqli_fetch_object($rs)) {
        $resultArr[] = $row;
    }
}
ClosedDBConnection($cn);

$newspaperAtHomeOffice = $resultArr;

*/
$condition = '?abc=abc';

if (isset($_REQUEST['user_category'])) {
    $condition .= "&user_category=" . $_REQUEST['user_category'];
}
$istishonBotTextReplyReporting = json_decode(file_get_contents($istishonBotTextReplyReportingUrl . $condition));
//print_r($newOldUserReporting);
//exit;

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
                            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <!--<label for="role">Choose User Category<span class="text-danger">*</span></label>
                                <select name="user_category" id="user_category" class="form-control smart_select ">

                                    <option disabled selected value> -- Select a Category --</option>
                                    <option value="new">New User</option>
                                    <option value="old">Old User</option>
                                    <?php if (isset($_REQUEST['user_category'])) { ?> selected="selected" <?php } ?>

                                </select>-->
                            </div>
                            <div id="btnDiv" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">



                               <span id="btnDiv" class="pull-left">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>
                            </div>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="20%">Date</th>
                                        <th width="40%">FbID</th>
                                        <th width="40%">Text</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($istishonBotTextReplyReporting)) { ?>
                                        <?php
                                        foreach ($istishonBotTextReplyReporting as $key => $row) {

                                            $created_at = !empty($row->created_at) ? $row->created_at : "";
                                            $msngr_id = !empty($row->msngr_id) ? $row->msngr_id : "";
                                            $qry = !empty($row->qry) ? $row->qry : "";

                                            ?>
                                            <tr class="gradeX">

                                                <td>
                                                    <?php echo $created_at; ?>
                                                </td>
                                                <td>
                                                    <?php echo $msngr_id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $qry; ?>
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
                var base_url = '<?php echo $textReplyDataExprtUrl;?>';

                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();

                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date);

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