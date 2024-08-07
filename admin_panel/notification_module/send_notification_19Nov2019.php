<?php
session_start();
//require_once '../config/config.php';

require '../lib/functions.php';
require '../config/service_config.php';

//$service=strtoupper($_REQUEST['service']);
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

$pageTitle = " Notification Send Module";

include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
//$serviceName = json_decode(file_get_contents($contentUploadableServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));

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
                        </header>

                        <div class="panel-body panel-primary">


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
                                    <form accept-charset="utf-8" id="upload_content_form"
                                          enctype="multipart/form-data" method="post">

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Service <span class="text-danger">*</span></label>
                                            <!-- <select name="service" class="form-control smart_select subscriber type">

                                                <option disabled selected value> -- select an option -- </option>
                                                <option value="DeenerkothaMylifeDailyAuto">Deener kotha BD</option>
                                                <option value="HoroscopeMylifeDailyAuto">Rashifol BD</option>
                                            </select>-->

                                            <select name="services"  id="services" class="form-control smart_select subscriber type">
                                                <option disabled selected value> -- select an option -- </option>
                                                <option value="NewsIstishon">News</option>
                                                <option value="IslamDailyIstishon">Islamic</option>
                                                <option value="HoroscopeIstishon">Horoscope</option>
                                                <option value="DailyBuzzLoveQuotes">LoveQuotes</option>
                                                <option value="DailyBuzzRelationshipTips">RelationshipTips</option>
                                                <option value="DailyBuzzWordOfTheDay">WordOfTheDay</option>
                                            </select>




                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Subscriber Type <span class="text-danger">*</span></label>
                                            <select name="subscriber_type" name="has_manaul"id="has_manual" value="Manual"onchange="showUpload()" class="form-control smart_select subscriber type">

                                                <option disabled selected value> -- select an option -- </option>
                                                <option value="All">All</option>
                                                <option value="Registered">Registered</option>
                                                <option value="Deregistered">Deregistered</option>
                                                <option value="Manual">Manual</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Text <span class="text-danger">*</span></label>
                                            <textarea rows="4" cols="50" class="form-control"name="text"></textarea>

                                        </div>
                                        <div id="msg_type_checkbox" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Message Type<span class="text-danger">*</span> </label>
                                            <input type="radio" name="msg_type" id="msg_type" value="English"> English
                                            <input type="radio" name="msg_type" id="msg_type" value="Bangla"> Bangla

                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                       <label class="label_check c_off">
                                            <!--<button type="button" id='has_multi'>Add Multimedia Content</button>-->
                                           <!--<input type="submit" class="btn btn-danger btn-block btn-sm"
                                                  name="has_multi" id="has_multi" value="Add Multimedia Content">-->

                                           <input type="checkbox" name="has_multi" id="has_multi" value="yes" onclick="showCheckbox()"> Add Multimedia Content<br>
                                          <!-- <script>$('#has_multi').click(function(){

                                                   $("#check_box").show();

                                               });</script>-->


                                       </label>

                                        </div>


                                        <div id="check_box" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Content Type<span class="text-danger">*</span> </label>
                                            <input type="checkbox" name="multi_type_image" id="multi_type_image"  value="image" onclick="showHideImageUploader()"> Image
                                            <input type="checkbox" name="multi_type_audio" id="multi_type_audio"  value="audio" onclick="showHideAudioUploader()"> Audio
                                            <input type="checkbox" name="multi_type_video" id="multi_type_video"  value="video" onclick="showHideVideoUploader()"> Video
                                            </br>
                                            <label id="lblImage" name="lblImage" >Image File</label> <input type="file" name="imageFile" id="imageFile"  />
                                            <label id="lblAudio" name="lblAudio" >Audio File</label><input type="file"  name="audioFile" id="audioFile"  />
                                            <label id="lblVideo" name="lblVideo" >Video File</label><input type="file"  name="videoFile" id="videoFile"  />
                                        </div>
                                        <!--<div id="selectedFiles"></div>-->

                                        <div id="drop_down" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Choose Excel File (.xls or .xlsx) <span class="text-danger">*</span>
                                            </label>
                                            <input type="file"  accept=".xlsx, .xls" name="file_excel[]"
                                                   multiple="multiple"
                                                   class="form-control-file" id="exampleFormControlFile2">
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

            //hiding all multimedia File uploader
            $("#imageFile").hide();
            $("#lblImage").hide();
            $("#audioFile").hide();
            $("#lblAudio").hide();
            $("#videoFile").hide();
            $("#lblVideo").hide();


            $("#drop_down").hide();

            $(".smart_select").select2();

            $("#check_box").hide();



            $(document).on('click', '#save_data', function (event) {


                event.preventDefault();
                //this.disabled = true;
                var myForm = document.getElementById('upload_content_form');
                var form_data = new FormData(myForm);
                $("#save_data").hide();
                for (var [key, value] of form_data.entries()) {
                    //console.log(key, value);
                }
                showLoader();
                //console.log(form_data); //return;

                $.ajax({
                    url: "../../bot_service_api/fileUploaderSendNotification.php",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {
                                this.disabled = true;
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

        function showUpload()
        {

            var ddl = document.getElementById("has_manual");

            if (ddl.value == 'Manual') {

                $("#drop_down").show();

            } else {

                $("#drop_down").hide();
            }
        }

        function showCheckbox()
        {

            var checkBox = document.getElementById("has_multi");

            if (checkBox.checked == true) { // if service name is quiz

                 $("#check_box").show();

            } else {

                $("#check_box").hide();
            }
        }
        function showHideImageUploader()
        {
            var checkBox = document.getElementById("multi_type_image");
            if (checkBox.checked == true) {
                $("#imageFile").show();
                $("#lblImage").show();
            } else {
                $("#imageFile").hide();
                $("#lblImage").hide();
            }
        }
        function showHideAudioUploader()
        {
            var checkBox = document.getElementById("multi_type_audio");
            if (checkBox.checked == true) {
                $("#audioFile").show();
                $("#lblAudio").show();
            } else {
                $("#audioFile").hide();
                $("#lblAudio").hide();
            }
        }
        function showHideVideoUploader()
        {
            var checkBox = document.getElementById("multi_type_video");
            if (checkBox.checked == true) {
                $("#videoFile").show();
                $("#lblVideo").show();
            } else {
                $("#videoFile").hide();
                $("#lblVideo").hide();
            }
        }
        function showLoader() {
            $('#loading').show();
            //$('save_data').disabled = true;
        };

    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>