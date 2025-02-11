<?php
session_start();

require '../lib/functions.php';
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

$pageTitle = "Quiz Content Modification";
$tabActive = "content_management";
$subTabActive = "update_quiz_content";
$manageQuizUrl = $redirectUrl = baseUrl("content_management/manage_quiz_content.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

echo $_REQUEST['CategoryID'];

// check save button
/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save'])) {

        $roleName = $_POST['role_name'];
        if (empty($roleName)) {
            $errorMsg .= "<p>Role Name Required.</p>";
        }

        if (!empty($roleName)) {
            if (isDataExists('admin_roles', 'role_name', $roleName)) {
                $errorMsg .= "<p>Role name already exists. please choose a unique name. </p>";
            }
        }

        if (null == $errorMsg) {
            $data = array(
                'role_name' => cleanInput($roleName),
                'created_by' => $adminId,
                'created_at' => date('Y-m-d H:i:s'),
            );

            if (doInsert('admin_roles', $data)) {
                $_SESSION['successMsg'] = 'Role added successfully';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Role creation failed !!';
            }
        }
    }
}*/
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
                              <a href="<?php echo $manageQuizUrl; ?>" class=" btn btn-success btn-xs"> Manage Quiz Content</a>
                          </span>
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
                                    <form accept-charset="utf-8" id="service_content_edit_form"
                                          enctype="multipart/form-data">

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                           <!-- <label for="role">Choose Category <span
                                                        class="text-danger">*<?php /*echo $_REQUEST['CategoryID']; */?></span></label>
                                            <select name="service_category_name" class="form-control smart_select ">
                                                <?php /*$serviceName = str_replace('\'', '', $_REQUEST['serviceID']);

                                                foreach ($serviceDetailsArray[$serviceName] as $key => $val) { */?>
                                                    <option value="<?php /*echo $key */?>"<?php /*if (isset($_REQUEST['CategoryID']) && $_REQUEST['CategoryID'] == $key) { */?> selected="selected" <?php /*} */?>><?php /*echo $val; */?>
                                                    </option>

                                                <?php /*} */?>
                                            </select>-->
                                        </div>

                                        <div id="content_text"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Content Text <span
                                                        class="text-danger">*</span></label>
                                            <textarea name="content_text"
                                                      class="form-control"><?php echo (isset($_REQUEST['content_text'])) ? trim($_REQUEST['content_text']) : ''; ?></textarea>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div id="content_status"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Content Status<span class="text-danger">*</span></label>
                                            <select name="content_status" class="form-control smart_select"/>
                                            <option value="Active"
                                                <?php if (isset($_REQUEST['content_status']) && $_REQUEST['content_status'] == "Active") { ?> selected="selected" <?php } ?>>
                                                Active
                                            </option>
                                            <option value="Inactive"
                                                <?php if (isset($_REQUEST['content_status']) && $_REQUEST['content_status'] == "Inactive") { ?> selected="selected" <?php } ?>>
                                                Inactive
                                            </option>
                                            <option value="SENT"
                                                <?php if (isset($_REQUEST['content_status']) && ($_REQUEST['content_status'] == "Sent" || $_REQUEST['content_status'] == "SENT")) { ?> selected="selected" <?php } ?>>
                                                Sent
                                            </option>
                                            <option value="FAILED"
                                                <?php if (isset($_REQUEST['content_status']) && ($_REQUEST['content_status'] == "Failed" || $_REQUEST['content_status'] == "FAILED")) { ?> selected="selected" <?php } ?>>
                                                Failed
                                            </option>

                                            </select>

                                        </div>

                                        <div id="content_activation_date_div"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Activation Date <span
                                                        class="text-danger">*</span></label>
                                            <input name="content_activation_date" class="form-control"
                                                   value="<?php echo (isset($_REQUEST['content_activation_date'])) ? trim($_REQUEST['content_activation_date']) : ''; ?>"
                                            </input>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="content_image_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <a target="_blank" href="<?php echo $_REQUEST['content_image']; ?>"> <label
                                                        for="role"><img src="<?php echo $_REQUEST['content_image']; ?>"
                                                                        alt="no image"
                                                                        width="150"
                                                                        height="80"
                                                                        style="max-width:95%;border:3px solid black;"></label>
                                            </a>

                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">

                                            <label class="label_check c_on" for="has_file">
                                                <input type="checkbox" name="has_image_file" class=" form-control-file"
                                                       id="has_image_file" value="yes" onclick="showImageField()">
                                                Add/Change Image</label>
                                        </div>
                                        <div id="content_image" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="content_image" class="form-control "/>
                                        </div>


                                        <div class="clearfix"></div>
                                        <div id="content_audio_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <audio controls src="<?php echo $_REQUEST['content_audio']; ?>"
                                                   alt="no image"
                                                   width="150"
                                                   height="80"
                                                   style="max-width:95%;border:3px solid black;">
                                                <code>audio</code>
                                            </audio>


                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">

                                            <label class="label_check c_on" for="has_file">
                                                <input type="checkbox" name="has_audio_file" class=" form-control-file"
                                                       id="has_audio_file" value="yes" onclick="showAudioField()">
                                                Add/Change Audio</label>
                                        </div>
                                        <div id="content_audio"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Audio<span class="text-danger">*</span></label>
                                            <input type="file" name="content_audio" class="form-control "/>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="content_video_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <video controls src="<?php echo $_REQUEST['content_video']; ?>"
                                                   alt="no image"
                                                   width="150"
                                                   height="80"
                                                   style="max-width:95%;border:3px solid black;">
                                            </video>

                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">

                                            <label class="label_check c_on" for="has_file">
                                                <input type="checkbox" name="has_video_file" class=" form-control-file"
                                                       id="has_video_file" value="yes" onclick="showVideoField()">
                                                Add/Change Video</label>
                                        </div>
                                        <div id="content_video"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Video<span class="text-danger">*</span></label>
                                            <input type="file" name="content_video" class="form-control "/>
                                        </div>
                                        <div class="clearfix"></div>

                                        <input type="hidden" id="action_type" name="action_type"
                                               value="update_quiz_content">
                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">
                                        <input type="hidden" id="content_id" name="content_id"
                                               value="<?php echo (isset($_REQUEST['updateId'])) ? $_REQUEST['updateId'] : ''; ?>"/>
                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-danger btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
                                        </div>
                                        <div class="col-md-3">
                                            <a href="manage_service_content.php?serviceID='<?php echo $_REQUEST['serviceID']; ?>'"
                                               class="btn btn-default btn-block btn-sm">Cancel
                                            </a>
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

            //  $("#has_file").prop("checked", true);
            $("#content_image").hide();
            $("#content_audio").hide();
            $("#content_video").hide();

            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();

                $("#save_data").hide();
                showLoader();
                var myForm = document.getElementById('service_content_edit_form');
                var form_data = new FormData(myForm);

                var catID = "<?= $_REQUEST['CategoryID'] ?>";
                form_data.set('service_category_name',catID);

                for (var [key, value] of form_data.entries()) {
                    console.log('key', key);
                    if (value == 0 || value == '') {
                        alert(key + ' is empty');
                        var error = 1;
                        break;
                    }
                }
                if (error) {
                    return;
                }
                console.log(form_data); //return;

                $.ajax({
                    // url: "../../BOT/api/updateServiceContent.php",
                    url: "<?php echo $updateServiceContentApiUrl;?>",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {

                                <?php  $uri = PROJECT_BASE_PATH . "/content_management/manage_service_content.php";?>
                                // var service_name = document.getElementById('service_category_name').value;
                                // alert(service_name);
                                window.location.replace('<?php echo $uri;?>');

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
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        $.alert('<div class="alert alert-danger">' + errorMessage + '</div>');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                })
            });

        });

        function showLoader() {
            $('#loading').show();
            $('save_data').disabled = true;
        };

        function showCategory() {
            var e = document.getElementById("service_name");
            var service_name = e.options[e.selectedIndex].text;
            alert(service_name);
            createCookie("service_name", service_name, "10");

            function createCookie(name, value, days) {
                var expires;
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                } else {
                    expires = "";
                }
                document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
            }
        }

        function showImageField() {

            var checkBox = document.getElementById("has_image_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#content_image").show();

            } else {
                $("#content_image").hide();
            }
        }

        function showAudioField() {

            var checkBox = document.getElementById("has_audio_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#content_audio").show();

            } else {
                $("#content_audio").hide();
            }
        }

        function showVideoField() {

            var checkBox = document.getElementById("has_video_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#content_video").show();

            } else {
                $("#content_video").hide();
            }
        }
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>