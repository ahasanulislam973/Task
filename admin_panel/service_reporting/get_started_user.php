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

$pageTitle = "Get Started User ";
$tabActive = "service_reporting";
$subTabActive = "get_started_user";

$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;

$condition = "?abc=abc" . "&organization_id=" . $_SESSION['admin_login_info']['organization_id'];
if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    $condition .= "&first_date=" . trim($_REQUEST['first_date']) . "&last_date=" . trim($_REQUEST['last_date']);
    $_SESSION['successMsg'] = "Filter Applied From $_REQUEST[first_date] To $_REQUEST[last_date]";
   
}

// $apiHitUrl = $getStartedDataUrl . $condition;
$apiHitUrl = $getStartedDataServerSideUrl . $condition;

// echo $apiHitUrl;die();
$getStartedData = json_decode(file_get_contents($apiHitUrl));


include_once INCLUDE_DIR . 'header.php';
?>
    <!--dynamic data table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <!--Dynamic Data Table-->
    <!--<script type="text/javascript" src="<?php /*echo baseUrl('assets/modules/advanced-datatable/media/js/jquery.dataTables.js');*/ ?>"></script>
    <script type="text/javascript" src="<?php /*echo baseUrl('assets/modules/data-tables/DT_bootstrap.js');*/ ?>"></script>-->


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

                                            <form action="get_started_user.php">

                                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <label class="control-label text-danger">
                                                        Set Date Range *</label>
                                                    <input id="startDate" autocomplete="off" placeholder="Start Date"
                                                           class="form-control" type="text"/>
                                                    <input id="endDate" autocomplete="off" class="form-control"
                                                           placeholder="End Date"
                                                           type="text"/>

                                                    <!--<input class="form-control" type="text"
                                                           name="daterange" autocomplete="off"/>-->

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

                                                    <!--<a href="javascript:void(0)" class="btn btn-danger btn-block btn-sm"
                                                       onclick="getStartedUserReport()">
                                                        Apply Filter
                                                    </a>-->

                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                    <a href="get_started_user.php" <span
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
                                       id="getStartedUser">

                                    <thead>
                                    <tr class="">
                                        <th width="10%">Date-time</th>
                                        <th width="10%">FB ID</th>
                                        <th width="10%">FB Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($getStartedData)) { ?>
                                        <?php
                                        foreach ($getStartedData as $key => $row) {
                                            $entryTime = !empty($row->entry_time) ? $row->entry_time : "";
                                            $facebookId = !empty($row->facebook_id) ? $row->facebook_id : "";
                                            $facebookName = !empty($row->facebook_name) ? $row->facebook_name : "";

                                            ?>
                                            <tr class="gradeX">
                                                <td>
                                                    <?php echo $entryTime; ?>
                                                </td>
                                                <td>
                                                    <?php echo $facebookId; ?>
                                                </td>

                                                <td>
                                                    <?php echo $facebookName; ?>
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
            $('#getStartedUser').DataTable({
                "ordering": true,
                "aaSorting": [[0, "desc"]],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= $apiHitUrl; ?>'
                },
                'columns': [
                    {data: 'entry_time'},
                    {data: 'facebook_id'},
                    {data: 'facebook_name'}
                ]
            });

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
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
                //   var base_url = 'https://' + window.location.host + '/BOT/export_data/';
                var base_url = '<?php echo $getStartedDataExprtUrl;?>';
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