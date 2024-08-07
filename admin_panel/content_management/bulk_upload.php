<?php
session_start();
require '../lib/functions.php';
require '../config/service_config.php';

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

$pageTitle = " Bulk Content Upload For Services";
$tabActive = "content_management";
$subTabActive = "bulk_upload";
$manageAdminUrl = $redirectUrl = baseUrl("content_management/single_upload.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$organizationId = $_SESSION['admin_login_info']['organization_id']; // organization_id from session
$errorMsg = null;

$organizations = getOrganization();
$serviceName = json_decode(file_get_contents($contentUploadableServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));

?>
    <!-- select 2 css -->
    <link href="<?php echo baseUrl('assets/css/select2.min.css'); ?>" rel="stylesheet">
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <!--  <a href="<?php /*echo $addCategoryUrl; */ ?>" class=" btn btn-success btn-xs"> Add Category</a>-->
                            </span>
                        </header>

                        <div class="panel-body panel-primary">
    <span class="pull-right">
                            <a href="#myModal" data-toggle="modal" class="btn btn-primary mb-2">
                              Sample Templates
                            </a>
                            </span>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                                 id="myModal" class="modal fade">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Content Upload Templates</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php if ($organizationId<>10 && $organizationId != 16 && $organizationId != 27) { ?>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">

                                                <a href="/bot_service_api/upload_templates/quiz_template.xls">

                                                    <h5 class="control-label "><img src="../assets/img/xls-file.png"
                                                    width="10%" height="5%"/>
                                                        Quiz Template </h5></a>
                                            </div>
                                            <?php } ?>
                                            <?php if ($organizationId == 1 || $organizationId == 2) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/deenerkotha_template.xlsx">
                                                        <h5 class="control-label "><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            Deener Kotha Template </h5></a>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/horoscope_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            Rashifol Template </h5></a>

                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/news_istishon_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            NewsIstishon Template </h5></a>

                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/horoscope_Istishon_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            HoroscopeIstishon Template </h5></a>

                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/islam_daily_istishon_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            IslamDailyIstishon Template </h5></a>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/DailyBuzzLoveQuotes_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            DailyBuzzLoveQuotes Template </h5></a>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/DailyBuzzWordOfTheDay_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            DailyBuzzWordOfTheDay Template </h5></a>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/DailyBuzzRelationshipTips_template.xlsx">
                                                        <h5 class="control-label"><img src="../assets/img/xls-file.png"
                                                        width="10%" height="5%"/>
                                                            DailyBuzzRelationshipTips Template </h5></a>
                                                </div>


                                            <?php } ?>
                                            <?php if ($organizationId == 3) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/telenor_content_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Telenor Content Template</h5>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($organizationId == 4) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/THT_voting_poll_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Voting poll </h5>
                                                    </a>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/mizzima_service_template.xlsx">

                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Mizzima Template </h5>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($organizationId == 6) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/trivia_quiz_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Trivia Quiz </h5>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($organizationId == 10) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/horoscope_mtk_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            MTK Horoscope </h5>
                                                    </a>
                                                </div>
                                            <?php } ?>
											<?php if ($organizationId == 27) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/horoscope_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Malaya Horoscope </h5>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($organizationId == 16|| $organizationId == 21 || $organizationId == 23) { ?>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <a href="/bot_service_api/upload_templates/voting_poll_template.xlsx">
                                                        <h5><img src="../assets/img/xls-file.png" width="10%"
                                                                 height="5%"/>
                                                            Voting Poll Template </h5>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger pull-right">Close
                                            </button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="row">

                                <div class="col-md-12">
                                    <?php if (null != $errorMsg) { ?>
                                        <div class="alert alert-danger">
                                            <strong>Warning!</strong> <br>
                                            <?php echo $errorMsg; ?>
                                        </div>
                                    <?php } elseif (isset($_SESSION['errorMsg'])) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong>Warning!</strong> <br>
                                            <?php
                                            echo $_SESSION['errorMsg'];
                                            unset($_SESSION['errorMsg']);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <form accept-charset="utf-8" id="upload_content_form" enctype="multipart/form-data">

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Service <span class="text-danger">*</span></label>
                                            <select name="purpose" class="form-control smart_select serviceName"
                                                    onchange="populateQuizCategory(this)">
                                                <?php foreach ($serviceName as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php if (isset($_REQUEST['service_name']) && $_REQUEST['service_name'] == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['admin_login_info']['organization_id'] == 0) { ?>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="organization">Organization/Operator <span
                                                            class="text-danger">(Except Super Power)*</span></label>
                                                <select name="organization_id" class="form-control">
                                                    <?php foreach ($organizations as $key => $val) { ?>
                                                        <option value="<?php echo $key ?>">
                                                            <?php echo $val; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" id="organization_id" name="organization_id"
                                                   value="<?php echo $_SESSION['admin_login_info']['organization_id']; ?>">
                                            <?php
                                        } ?>
                                        <div class="clearfix"></div>

                                        <div id="quiz_category" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz/Service Category Name<span
                                                        class="text-danger">*</span></label>
                                            <select name="category_name" id="category_id"
                                                    class="form-control smart_select quiz_category_id"
                                                    onchange="populateQuiz(this)">

                                            </select>
                                        </div>

                                        <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz/On-Demand Service Name <span
                                                        class="text-danger">*</span></label>
                                            <select name="quiz_name" id="quiz_id"
                                                    class="form-control smart_select quiz_name">

                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Choose Excel File (.xls or .xlsx) <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" accept=".xlsx, .xls" name="file_excel[]"
                                                   multiple="multiple"
                                                   class="form-control-file" id="exampleFormControlFile2">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label class="label_check c_off"><input type="checkbox" name="has_file"
                                                                                    id="has_file" value="yes"
                                                                                    onclick="showFilesField()">
                                                Multimedia Content(Image/audio/Video)</label>
                                        </div>
                                        <div id="zip_files" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>File (Zipped)<span class="text-danger">*</span> </label>
                                            <input type="file" accept="application/zip" name="file_zipped[]"
                                                   multiple="multiple" class="file_zipped form-control-file"
                                                   id="exampleFormControlFile1">
                                        </div>
                                        <input type="hidden" name="user_id" id="user_id"
                                               value="<?php echo(isset($_SESSION['admin_login_info']['user_id']) ? $_SESSION['admin_login_info']['user_id'] : '') ?>"/>

                                        <div class="clearfix"></div>

                                        <div class="col-md-3" id="save_data_btn">
                                            <input type="submit" class="btn btn-danger btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
                                        </div>
                                        <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1">

                                        </div>
                                        <div id="loading" class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8"
                                             style="display: none">
                                            <img src="../assets/img/loader.gif" alt="Processing....."/>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        </div>
                                    </form><!-- Form -->
                                </div>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>

    <!-- select 2 js -->
    <script type="text/javascript" src="<?php echo baseUrl('assets/js/select2.full.min.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".smart_select").select2();

            $("#zip_files").hide();

            var serviceName = $('.serviceName option:selected').val();

            if (serviceName == 'TelenorEnglishLearning' || serviceName == 'Quiz_Ondemand_Service') { // if service name is quiz

                $("#quiz_category").show();

            } else {
                $("#quiz_category").hide();

            }
            if (serviceName == 'Quiz_Ondemand_Service') { // if service name is BD quiz

                $("#quiz_name").show();

            } else {

                $("#quiz_name").hide();
            }


            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();

                var myForm = document.getElementById('upload_content_form');
                var form_data = new FormData(myForm);
                $("#save_data").hide();
                for (var [key, value] of form_data.entries()) {
                    console.log(key, value);
                }

                showLoader();
                console.log(form_data); //return;

                $.ajax({
                    url: "../../bot_service_api/fileUploader.php",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {

                                $('#upload_content_form')[0].reset();
                                alert(apires.status_msg);
                                $("#save_data").show();
                                $("#loading").hide();

                            } else {
                                alert(apires.status_msg);
                                $("#save_data").show();
                                $("#loading").hide();
                            }
                        } catch (e) {
                            $("#save_data").show();
                            $("#loading").hide();
                            alert('Opps!! Error Occurred. Please Check Console for details.');
                            console.error(e);
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $("#save_data").show();
                        $("#loading").hide();
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        $.alert('<div class="alert alert-danger">' + errorMessage + '</div>');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            });

        });

        function populateQuizCategory(val) {

            var serviceName = $('.serviceName option:selected').val();

            //alert(serviceName);

            if (serviceName == 'TelenorEnglishLearning' || serviceName == 'Quiz_Ondemand_Service') { // if service name is quiz
                // console.log(conceptName);
                $("#quiz_category").show();

            } else {
                $("#quiz_category").hide();

            }
            if (serviceName == 'Quiz_Ondemand_Service') { // if service name is BD quiz

                $("#quiz_name").show();
                var url = '<?php echo $quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']; ?>';


            } else {
                $("#quiz_name").hide();
                var url = '<?php echo $telenorCategoryNameUrl; ?>';
            }

            let dropdown = $('#category_id');
            dropdown.empty();
            /* dropdown.append('<option  disabled>Choose Category</option>');*/
            dropdown.prop('selectedIndex', 0);
            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                })
            });


        }

        function showFilesField() {

            var checkBox = document.getElementById("has_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#zip_files").show();

            } else {
                $("#zip_files").hide();
            }
        }

        function showLoader() {
            $('#loading').show();
            $('save_data').disabled = true;
        };

        function populateQuiz(sel) {

            var x = 0;
            x = sel.value;

            var category_id = $('.quiz_category_id option:selected').val();

            let dropdown = $('#quiz_id');
            dropdown.empty();
            /*  dropdown.append('<option  disabled>Choose Quiz</option>');*/
            dropdown.prop('selectedIndex', 0);
            var url = '<?php echo $quizNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>' + '&quiz_category_id=' + category_id;

            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                })
            });
        }
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>