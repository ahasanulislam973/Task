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


$organizations = getOrganization();
/*
$pageTitle = "Export Data and Send Mail";
$tabActive = "newspaper_reporting";
$subTabActive = "export_send_mail";
$mailSubject = "Newspaper At Home/Office Log";
$condition = '';
$_SESSION['successMsg'] = '';
$serviceSelected = false;
*/

$showSendEmailAndData = false;
$pageId = '';
$organizationId = $_SESSION['admin_login_info']['organization_id'];
if (isset($organizationId) && $organizationId == 4) { // himalayan
    $pageId = '1244238152401671';
    $showSendEmailAndData = true;
} else if (isset($organizationId) && $organizationId == 1) { // my life
    $pageId = '262575581058668';
}

//$pageTitle = "Node Wise User Logs";
//$tabActive = "node_log";
//$subTabActive = "node_log_raw_data";
$pageTitle = "Export Data and Send Mail";
$tabActive = "newspaper_reporting";
$subTabActive = "export_data_and_send_mail";
$condition = '';
$_SESSION['successMsg'] = '';

$mailSubject = $pageTitle;
$condition = "?abc=abc&page_id=$pageId";

if (isset($_REQUEST['messenger_id']) && $_REQUEST['messenger_id'] <> '') {
    //$condition .= "&messenger_id=" . $_REQUEST['messenger_id'];
}

if (isset($_REQUEST['first_date']) && $_REQUEST['first_date'] <> '' && isset($_REQUEST['last_date']) && $_REQUEST['last_date'] <> '') {
    //$condition .= "&first_date=" . $_REQUEST['first_date'] . "&last_date=" . $_REQUEST['last_date'];
    //$_SESSION['successMsg'] = " From $_REQUEST[first_date] To $_REQUEST[last_date]";
}

if (isset($_REQUEST['sourceNode']) && $_REQUEST['sourceNode'] <> '') {
    //$condition .= "&sourceNode=" . $_REQUEST['sourceNode'];

}



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
                                <label for="role">Choose User Report<span class="text-danger">*</span></label>
                                <select name="user_report" id="user_report" class="form-control smart_select ">

                                    <option disabled selected value> -- Select a Report --</option>
                                    <option value="node_log_raw_data">Node Log Raw Data</option>
                                    <option value="new_old_user">New Old User</option>
                                    <option value="newspaper_home_office">Newspaper At Home or Office</option>
                                    <option value="voting_poll">Voting Poll</option>
                                    <option value="all">Voting Poll</option>
                                        <!-- <option value="breaking_news">Breaking News</option>  -->
                                    <?php if (isset($_REQUEST['user_report'])) { ?> selected="selected" <?php } ?>

                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label ">
                                    Set Date Range *</label>

                                <input class="form-control" type="text"
                                       name="daterange" autocomplete="off"/>

                            </div>

                            <div class="clearfix"></div>

                            <input type="hidden" id="first_date" name="first_date"
                                   value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['first_date']; ?>">
                            <input type="hidden" id="last_date" name="last_date"
                                   value="<?php if (isset($_REQUEST['first_date'])) echo $_REQUEST['last_date']; ?>">
                            <div class="clearfix"></div>

                            <div id="btnDiv" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

                               <button id="export_data_send_mail" name="export_data_send_mail"
                                        class="btn btn-sm btn-danger">
                                    Export Data & Send Mail
                                </button>

                                </span>

                                <!--<a href="#myModal" data-toggle="modal" class="btn btn-sm btn-success">
                                    Filter
                                </a> -->
                            </div>
                            <div class="clearfix"></div>




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

               $('#btnDiv').on('click', '#export_data_send_mail', function () {

                var user_report = document.getElementById('user_report').value;
                //alert(user_report);return;
                var mailSubject='';

                if (user_report == '') {
                    alert('Please select a Report ')
                    return;
                }

                 var first_date = $("#first_date").val();
                 var last_date = $("#last_date").val();
				 
				  if (first_date == '') {
                    alert('Please select a Date range ')
                    return;
                }

                if(user_report=='node_log_raw_data') {
                    mailSubject='Node Log Raw Data';
                    var base_url = '<?php echo $exportDatanSendMail;?>';
                    var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';
                    var sourceNode = '<?php if (isset($_REQUEST['sourceNode'])) echo $_REQUEST['sourceNode']; ?>';

                    //alert(user_report);alert(first_date);alert(last_date);return;
                    window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject + '&page_id=' + '<?= $pageId; ?>' + '&sourceNode=' + sourceNode);

                 }
                 if(user_report=='new_old_user') {
                     mailSubject='New Old User';
                     var base_url = '<?php echo $himalayanLogExportDataSendMail; ?>';
                     var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                     var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                     var purpose = 'new_old_user';
                     var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';
					 var user_category ='old';

                     window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&purpose=" + purpose + "&user_category=" + user_category);

                 }
                 if(user_report=='newspaper_home_office') {

                     //alert(user_report);alert(first_date);alert(last_date);return;
                     mailSubject='Newspaper At Home or Office';
                     var base_url = '<?php echo $himalayanLogExportDataSendMail; ?>';
                     var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';
                     var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                     var purpose = 'newspaper_at_home_office';
                     var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                     window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn + "&purpose=" + purpose);

                   }
                   if(user_report=='voting_poll') {
                       //alert(user_report);alert(first_date);alert(last_date);return;
                       mailSubject='Voting Poll';
                       var base_url = '<?php echo $quizLogExprtAndSendMail; ?>';
                       var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; else echo $votingPollQuizId;?>';
                       var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                       var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                       //window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);
                       window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);
                   }
                   if(user_report=='breaking_news') {
                       //alert(user_report);alert(first_date);alert(last_date);return;
                       mailSubject='Breaking News';
                       var base_url = '<?php echo $quizLogExprtAndSendMail; ?>';
                       var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; else echo $breakingNewsCategoryId;?>';
                       var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                       var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                       //window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);
                       window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);

                   }
                   if(user_report=='all') {
                       //alert(user_report);alert(first_date);alert(last_date);return;
                       mailSubject='All Report';
                       var base_url = '<?php echo $himalayanAllReportExportDataSendMail; ?>';
                       //var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; else echo $votingPollQuizId;?>';
                       var msisdn = '<?php if (isset($_REQUEST['msisdn'])) echo $_REQUEST['msisdn']; ?>';
                       var messenger_id = '<?php if (isset($_REQUEST['messenger_id'])) echo $_REQUEST['messenger_id']; ?>';

                       //window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + '<?= $mailSubject; ?>' + "&quiz_id=" + quiz_id + "&msisdn=" + msisdn);
                       window.open(base_url + '?first_date=' + first_date + "&last_date=" + last_date + '&messenger_id=' + messenger_id + '&back_url=' + '<?= $currentUrl; ?>' + '&mail_subject=' + mailSubject  + "&msisdn=" + msisdn);
                   }



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