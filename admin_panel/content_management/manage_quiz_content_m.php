<?php
session_start();
//require_once '../config/config.php';
require_once '../lib/functions.php';
require_once '../config/service_config.php';
require_once '../../bkash_referral_panel/config/service_config.php';



$pageTitle = "Manage Quiz Questions";
$tabActive = "content_management";
$subTabActive = "manage_quiz_content";
$uploadContentUrl = baseUrl('content_management/bulk_upload.php');

$condition = "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];
if (isset($_REQUEST['cluster_id'])) {
    $condition .= "&cluster_id=" . $_REQUEST['cluster_id'];
}
if (isset($_REQUEST['district_id'])) {
    $condition .= "&district_id=" . $_REQUEST['district_id'];
}


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
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>

                        </header>

                        <div class="panel-body">

                            <div id="quiz_category" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role"> Select Cluster<span class="text-danger">*</span></label>
                                <select name="cluster_id" id="cluster_id"
                                        class="form-control smart_select quiz_cluster_id"
                                        onchange="populateDistrict()">
                                    <?php if (isset($_REQUEST['cluster_id'])) { ?> selected="selected" <?php } ?>>

                                </select>
                            </div>

                            <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Selct District <span class="text-danger">*</span></label>
                                <select name="quiz_name" id="district_id"
                                        class="form-control smart_select quiz_name" onchange="getQuizContent(this);">
                                    <?php if (isset($_REQUEST['district_id'])) { ?> selected="selected" <?php } ?>>
                                </select>
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

            var url = '<?php echo $bkashReferralClusterNameUrl;?>';
            let dropdown = $('#cluster_id');
            dropdown.empty();
            /* dropdown.append('<option  disabled>Choose Category</option>');*/
            dropdown.prop('selectedIndex', 0);
            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['cluster_id'])) echo $_REQUEST['cluster_id'];?>';
                    // alert('catid=' + theValue);
                    $('option[value=' + theValue + ']')
                        .attr('selected', true);
                })
                populateDistrict();
            });

        });


        function populateDistrict() {

            var cluster_id = $('.quiz_cluster_id option:selected').val();

            let dropdown = $('#district_id');
            dropdown.empty();
            /*     dropdown.append('<option  disabled>Choose Quiz</option>');*/
            dropdown.prop('selectedIndex', 0);
            var url = '<?php  echo $bkashReferralDistrictNameUrl ;?>' + '&cluster=' + cluster_id;

            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['district_id'])) echo $_REQUEST['district_id'];?>';
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
            var cluster_id = $('.quiz_cluster_id option:selected').val();
            //  alert('catid=' + cluster_id);
            //  alert('quizid=' + x);
            <?php  $uri = PROJECT_BASE_PATH . "/content_management/manage_quiz_content.php?district_id=";?>
            window.location.replace('<?php echo $uri;?>' + x + "&cluster_id=" + cluster_id);
        }
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>