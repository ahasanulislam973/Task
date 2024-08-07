<?php
session_start();
require_once '../config/config.php';
require_once '../config/service_config.php';
// date_default_timezone_set("Asia/Dhaka");

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

$pageTitle = "Bot Leads";
$tabActive = "service_reporting";
$subTabActive = "bot_leades";

$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

$condition = "?abc=abc" . "&organization_id=" . $_SESSION['admin_login_info']['organization_id'];
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . trim($_REQUEST['first_date']) . "&last_date=" . trim($_REQUEST['last_date']);
    $_SESSION['successMsg'] = "Filter Applied From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

$apiHitUrl = $CAssurebotLeadsDataServerSideUrl . $condition;
$botLeadsData = json_decode(file_get_contents($apiHitUrl));

/*
$logFileName = "logs/sohoj_get_started_reporting_panel_" . (string)date("Y_m_d_A", time()) . ".txt";
$logTxt = json_encode($_REQUEST) . "|";

$ch = curl_init($apiHitUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$smsSendApi = curl_exec($ch);
if (curl_errno($ch))
    $cURLerror = 'Request Error:' . curl_error($ch);

$logTxt .= "API_RESP: " . $smsSendApi . "|" . "cURL_ERR: " . $cURLerror;
*/

/*$smsSendResp = json_decode($smsSendApi);
switch (json_last_error()) {
    case JSON_ERROR_DEPTH:
        echo ' - Maximum stack depth exceeded. Specifies that the maximum stack depth has been exceeded.';
        break;
    case JSON_ERROR_CTRL_CHAR:
        echo ' - Unexpected control character found. Indicates that the error is in control characters. This usually happens incorrect encoding.';
        break;
    case JSON_ERROR_SYNTAX:
        echo ' - Syntax error, malformed JSON. Indicates that this is a syntax error.';
        break;
    case JSON_ERROR_STATE_MISMATCH:
        echo ' - JSON error state mismatch. Indicates that the associated JSON is not properly formed or invalid.';
        break;
    case JSON_ERROR_UTF8:
        echo ' - Indicates that error occurred due to malformed UTF-8 characters, which usually happens because of incorrect encoding.';
        break;
    case JSON_ERROR_NONE:
        echo ' - No errors. Specifies that no error occurred.';
        break;
}*/


include_once INCLUDE_DIR . 'header.php';
?>
    <!--dynamic data table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <!-- Datatable JS & CSS -->
    <link href='<?php echo baseUrl('assets/DataTables/datatables.min.css'); ?>' rel='stylesheet' type='text/css'>
    <script src="<?php echo baseUrl('assets/DataTables/datatables.min.js'); ?>"></script>


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

                                            <form action="bot_leads.php">

                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label text-danger">
                                                        Set Date Range *</label>
                                                    <input id="startDate" autocomplete="off" placeholder="Start Date"
                                                           class="form-control" type="text"/>
                                                    <input id="endDate" autocomplete="off" class="form-control"
                                                           placeholder="End Date"
                                                           type="text"/>

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
                                                    <a href="bot_leads.php" <span
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
                                <table class="display table table-bordered table-responsive dataTable"
                                       id="botLeadsUser">

                                    <thead>
                                    <tr class="">
                                        <th width="10%">Updated on</th>
                                        <th width="10%">FB ID</th>
                                        <th width="10%">Mobile Number</th>
                                        <th width="10%">Purpose</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($botLeadsData)) {
                                        foreach ($botLeadsData as $key => $row) {
                                            $updated_at = !empty($row->updated_at) ? $row->updated_at : "";
                                            $MESSENGER_ID = !empty($row->MESSENGER_ID) ? $row->MESSENGER_ID : "";
                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : "";
                                            $purpose = !empty($row->purpose) ? $row->purpose : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $updated_at; ?></td>
                                                <td><?php echo $MESSENGER_ID; ?></td>
                                                <td><?php echo $msisdn; ?></td>
                                                <td><?php echo $purpose; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
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
            $('#botLeadsUser').DataTable({
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= $apiHitUrl; ?>'
                },
                'columns': [
                    {data: 'updated_at'},
                    {data: 'MESSENGER_ID'},
                    {data: 'msisdn'},
                    {data: 'purpose'},
                ]
            });


            $('#startDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                change: function (e) {
                    var startDate = $('#startDate').val();
                    var now = new Date(startDate);
                    var dateString1 = moment(now).format('YYYY-MM-DD');
                    var first_date = document.getElementById('first_date');
                    first_date.value = dateString1;

                }
            });
            $('#endDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                change: function (e) {
                    var endDate = $('#endDate').val();
                    var now = new Date(endDate);
                    var dateString2 = moment(now).format('YYYY-MM-DD');
                    var last_date = document.getElementById('last_date');
                    last_date.value = dateString2;
                }
            });

            // code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                var base_url = '<?php echo $CAssurebotLeadsDataExprtUrl;?>';
                var first_date = $("#first_date").val();
                var last_date = $("#last_date").val();
                var organization_id = '<?=$_SESSION['admin_login_info']['organization_id'];?>'
                window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + "&organization_id=" + organization_id);
            });
        });
    </script>

    <!--script and style for new daterange picker-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>