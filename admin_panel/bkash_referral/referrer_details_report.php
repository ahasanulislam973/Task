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

$pageTitle = "Referrer Details Report";
$tabActive = "bkash_referral";
$subTabActive = "referrer_details_report";

$_SESSION['successMsg'] = '';

$condition = '?abc=abc';
if (isset($_REQUEST['msisdn'])) {
    $condition .= "&msisdn=" . $_REQUEST['msisdn'];
}

$referrerDetailsReportBkashReferral = json_decode(file_get_contents($referrerDetailsReportBkashReferralUrl . $condition));

//print_r($referrerDetailsReportBkashReferral);
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
                            <div id="display_order"
                                 class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Mobile Number</label>
                                <input type="text" name="msisdn" id="msisdn" value="+88"  class="form-control "/>
                            </div>


                              <div id="btnDiv" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <button id="show_data" name="show_data" class="btn btn-sm btn-info">
                                    Generate
                                </button>

                               <!-- <button id="export_data" name="export_data" class="btn btn-sm btn-success">
                                    Export Data
                                </button>-->

                              </div>
                            <div class="clearfix"></div>

                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="referrer_details_table">

                                    <thead>
                                    <tr class="">
                                        <th width="16%">ReferrerID</th>
                                        <th width="12%">Name</th>
                                        <th width="12%">MSISDN</th>
                                        <th width="12%">Registered?</th>
                                        <th width="12%">RegDate</th>
                                        <th width="12%">ProjectName</th>
                                        <th width="12%">FSID</th>
                                        <th width="12%">AppLinkGenerated?</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($referrerDetailsReportBkashReferral)) { ?>
                                        <?php
                                        foreach ($referrerDetailsReportBkashReferral as $key => $row) {

                                            $ReferrerID = !empty($row->ReferrerID) ? $row->ReferrerID : "";
                                            $Name = !empty($row->Name) ? $row->Name : "";
                                            $MSISDN = !empty($row->MSISDN) ? $row->MSISDN : "";
                                            $IsRegistered = !empty($row->IsRegistered) ? $row->IsRegistered : "";
                                            $RegDate = !empty($row->RegDate) ? $row->RegDate : "";
                                            $ProjectName = !empty($row->ProjectName) ? $row->ProjectName : "";
                                            $FSID = !empty($row->FSID) ? $row->FSID : "";
                                            $IsAppLinkGenerated = !empty($row->IsAppLinkGenerated) ? $row->IsAppLinkGenerated : "";

                                           ?>
                                            <tr class="gradeX">

                                                <td>
                                                    <?php echo $ReferrerID; ?>
                                                </td>
                                                <td>
                                                    <?php echo $Name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $MSISDN; ?>
                                                </td>

                                                <td>
                                                    <?php echo $IsRegistered; ?>
                                                </td>
                                                <td>
                                                    <?php echo $RegDate; ?>
                                                </td>
                                                <td>
                                                    <?php echo $ProjectName; ?>
                                                </td>
                                                <td>
                                                    <?php echo $FSID; ?>
                                                </td>
                                                <td>
                                                    <?php echo $IsAppLinkGenerated; ?>
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
            $('#referrer_details_table').dataTable({
                "aaSorting": [[4, "desc"]]
            });

            //code after Export Button Click
            $('#btnDiv').on('click', '#export_data', function () {

                var user_status = document.getElementById('user_status').value;
                alert(user_status); return;
                if (user_status == '') {
                    alert('Please select a Status ')
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

                var msisdn = document.getElementById('msisdn').value;

                if (msisdn == '') {
                    alert('Please Provide Mobile Number');
                    return;
                }
                <?php  $uri = PROJECT_BASE_PATH . "/bkash_referral/referrer_details_report.php?msisdn=";?>
                window.location.replace('<?php echo $uri;?>' + msisdn );

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