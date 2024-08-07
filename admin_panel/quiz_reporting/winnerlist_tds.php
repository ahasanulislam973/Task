<?php
session_start();
//require_once '../config/config.php';
require_once '../lib/functions.php';
require_once '../config/service_config.php';
if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}
$jagofm_winner_list_export = $baseUrl . "export_data/tds_winner_list_export.php";//newly added

$currentFileName = basename(__FILE__);
$currentModule = dirname(__FILE__);
$currentModule = explode('/', $currentModule);
$endOfModule = count($currentModule);
if (!hasPermission(strtolower($currentFileName), $currentModule[$endOfModule - 1])) {
    header('Location: ' . $accessDeniedPage);
    exit;
}

$pageTitle = "";
$tabActive = "quiz_reporting";
$subTabActive = "winnelist_ntv";
$uploadContentUrl = baseUrl('content_management/bulk_upload.php');

$condition = "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];
if (isset($_REQUEST['category_id'])) {
    $condition .= "&category_id=" . $_REQUEST['category_id'];
}
if (isset($_REQUEST['quiz_id'])) {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
}
$ntvwinnerList= $baseUrl . "reporting/tds_winner_list.php";
$ntvwinnerList = json_decode(file_get_contents($ntvwinnerList . $condition));

include_once INCLUDE_DIR . 'header.php';
?>

    <!--dynamic table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>

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
                          <span id="btnDiv" class="pull-right">
                            <button id="export_data" name="export_data" class="btn btn-sm btn-info">
                              Export Data
                            </button>
                            </span>

                        <div class="panel-body">

                            <div id="quiz_category" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Category Name<span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                        class="form-control smart_select quiz_category_id"
                                        onchange="populateQuiz()">
                                    <?php if (isset($_REQUEST['category_id'])) { ?> selected="selected" <?php } ?>>

                                </select>
                            </div>

                            <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Quiz Name <span class="text-danger">*</span></label>
                                <select name="quiz_name" id="quiz_id"
                                        class="form-control smart_select quiz_name" onchange="getQuizContent(this);">
                                    <?php if (isset($_REQUEST['quiz_id'])) { ?> selected="selected" <?php } ?>>
                                </select>
                            </div>

                            <div class="adv-table">
                                <table class="display table table-bordered table-responsive" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="5%">msngr_id</th>
                                        <th width="5%">msisdn</th>
                                        <th width="5%">name</th>
                                        <th width="5%">score</th>
                                        <th width="5%">time_required</th>
                                        <th width="15%">updated_at</th>
                                     
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($ntvwinnerList)) { ?>
                                        <?php

                                        foreach ($ntvwinnerList as $key => $row) {

                                            $msngr_id = !empty($row->msngr_id) ? $row->msngr_id : NULL;
                                            $msisdn = !empty($row->msisdn) ? $row->msisdn : NULL;
                                            $name = !empty($row->name) ? $row->name : NULL;
                                            $score = !empty($row->score) ? $row->score : NULL;
                                            $time_required = !empty($row->time_required) ? $row->time_required : NULL;
                                            $updated_at = !empty($row->updated_at) ? $row->updated_at : "";
                                            

                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $msngr_id; ?></td>
                                                <td><?php echo $msisdn; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <td><?php echo $score; ?></td>
                                                <td><?php echo $time_required; ?></td>
                                                <td><?php echo $updated_at; ?></td>
                                              
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
        });
    </script>
    <!--Dynamic Data Table-->
    <script type="text/javascript" language="javascript"
            src="<?php echo baseUrl('assets/modules/advanced-datatable/media/js/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.js'); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#my_data_table').dataTable({
                order: [[3, "desc"]]
            });

            var url = '<?php echo $quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>';
            let dropdown = $('#category_id');
            dropdown.empty();
            /* dropdown.append('<option  disabled>Choose Category</option>');*/
            dropdown.prop('selectedIndex', 0);
            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id'];?>';
                    // alert('catid=' + theValue);
                    $('option[value=' + theValue + ']')
                        .attr('selected', true);
                })
                populateQuiz();
            });

        });


        function populateQuiz() {

            var category_id = $('.quiz_category_id option:selected').val();

            let dropdown = $('#quiz_id');
            dropdown.empty();
            /*     dropdown.append('<option  disabled>Choose Quiz</option>');*/
            dropdown.prop('selectedIndex', 0);
            var url = '<?php if ($_SESSION['admin_login_info']['organization_id'] == 6) {
                $quizNameUrl = $quizNameAppUrl;
            } echo $quizNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>' + '&quiz_category_id=' + category_id;

            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id'];?>';
                    //  alert(theValue);
                    $('option[value=' + theValue + ']')
                        .attr('selected', true);
                })
            });
        }

        function getQuizContent(sel) {

            var x = 0;
            x = sel.value;
            // var quiz_category = document.getElementById("quiz_category").val();
            var category_id = $('.quiz_category_id option:selected').val();
            //  alert('catid=' + category_id);
            //  alert('quizid=' + x);
            <?php  $uri = PROJECT_BASE_PATH . "/quiz_reporting/winnerlist_tds.php?quiz_id=";?>
            window.location.replace('<?php echo $uri;?>' + x + "&category_id=" + category_id);
        }
		
		    //code after Export Button Click
        $('#btnDiv').on('click', '#export_data', function () {

           // var base_url = 'https://' + window.location.host + '/BOT/export_data/';
            var base_url = '<?php echo $jagofm_winner_list_export ;?>';
            var category_id = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id']; ?>';
            var quiz_id = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id']; ?>';


            window.open(base_url + "?quiz_id=" + quiz_id + "&category_id=" + category_id);

        });

    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>