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
$organizations = getOrganization();
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
                                    <form accept-charset="utf-8" id="quiz_add_form" enctype="multipart/form-data">

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
                                        <div id="quiz_category"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Category Name<span
                                                        class="text-danger">*</span></label>
                                            <select name="category_id" id="category_id"
                                                    class="form-control smart_select quiz_category_id"
                                                    onchange="populateQuiz()">
                                                <?php if (isset($_REQUEST['category_id'])) { ?> selected="selected" <?php } ?>
                                                >

                                            </select>
                                        </div>

                                        <div id="quiz_name"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Name <span
                                                        class="text-danger">*</span></label>
                                            <select name="quiz_id" id="quiz_id"
                                                    class="form-control smart_select quiz_name">
                                                <?php foreach ($quizName as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div id="quiz_question_text"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Question Text <span
                                                        class="text-danger">*</span></label>
                                            <textarea name="quiz_question_text"
                                                      class="form-control"><?php echo (isset($_REQUEST['question_text'])) ? trim($_REQUEST['question_text']) : ''; ?></textarea>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="question_option"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Question Options<span class="text-danger">*</span></label>
                                            <input name="question_option" class="form-control "
                                                   value="<?php echo (isset($_REQUEST['question_option'])) ? $_REQUEST['question_option'] : ''; ?>"
                                            />
                                        </div>

                                        <?php if (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId) {
                                            // do something later
                                            ?>
                                            <input name="question_ans" type="hidden" value="NA"/>
                                            <input name="quiz_question_point" type="hidden" value="1"/>
                                        <?php } else { ?>
                                            <div id="question_ans"
                                                 class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="role">Question Answer <span
                                                            class="text-danger">*</span></label>
                                                <input name="question_ans" class="form-control"
                                                       required
                                                       value="<?php echo (isset($_REQUEST['question_ans'])) ? $_REQUEST['question_ans'] : ''; ?>"
                                                />
                                            </div>
                                        <?php } ?>

                                        <div class="clearfix"></div>

                                        <div id="question_status"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Question Status<span class="text-danger">*</span></label>
                                            <select name="question_status" class="form-control smart_select"/>
                                            <option value="Active"
                                                <?php if (isset($_REQUEST['question_status']) && $_REQUEST['question_status'] == "Active") { ?> selected="selected" <?php } ?>>
                                                Active
                                            </option>
                                            <option value="Inactive"
                                                <?php if (isset($_REQUEST['question_status']) && $_REQUEST['question_status'] == "Inactive") { ?> selected="selected" <?php } ?>>
                                                Inactive
                                            </option>
                                            <option value="Que"
                                                <?php if (isset($_REQUEST['question_status']) && $_REQUEST['question_status'] == "Que") { ?> selected="selected" <?php } ?>>
                                                Que
                                            </option>
                                            <option value="Published"
                                                <?php if (isset($_REQUEST['question_status']) && $_REQUEST['question_status'] == "Published") { ?> selected="selected" <?php } ?>>
                                                Published
                                            </option>

                                            </select>

                                        </div>


                                        <?php if ((isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId) || (isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId_ProthomAlo)||(isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPoll_QuizId_ds) ) {
                                            $activationDate = isset($_REQUEST['activation_date']) ? date('Y-m-d', strtotime($_REQUEST['activation_date'])) : "";
                                            ?>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Activation Date <span class="text-danger">*</span> </label>
                                                <input type="text" placeholder="Activation Date"
                                                       name="activation_date"
                                                       class="form-control"
                                                       id="activation_date"
                                                       value="<?php echo $activationDate; ?>">

                                                       <input name="quiz_question_point" class="form-control " type="hidden"
                                                       value="2" /> 
                                                       
                                            </div>

                                        <?php } else { // we dont need question point for voting poll ?>
                                            <div id="quiz_question_point"
                                                 class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="role">Question Point<span
                                                            class="text-danger">*</span></label>
                                                <input name="quiz_question_point" class="form-control "
                                                       value="<?php echo (isset($_REQUEST['question_point'])) ? $_REQUEST['question_point'] : ''; ?>"
                                                />
                                            </div>
                                        <?php } ?>

                                        <div class="clearfix"></div>

                                        <div id="quiz_question_image_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <label for="role"><img src="<?php echo $_REQUEST['question_image']; ?>"
                                                                   alt="no image"
                                                                   width="150"
                                                                   height="80"
                                                                   style="max-width:95%;border:3px solid black;"></label>

                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">

                                            <label class="label_check c_on" for="has_file">
                                                <input type="checkbox" name="has_image_file" class=" form-control-file"
                                                       id="has_image_file" value="yes" onclick="showImageField()">
                                                Add/Change Image</label>
                                        </div>
                                        <div id="quiz_question_image"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="quiz_question_image" class="form-control "/>
                                        </div>


                                        <div class="clearfix"></div>
                                        <div id="quiz_question_audio_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <audio controls src="<?php echo $_REQUEST['question_audio']; ?>"
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
                                        <div id="quiz_question_audio"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Audio<span class="text-danger">*</span></label>
                                            <input type="file" name="quiz_question_audio" class="form-control "/>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="quiz_question_video_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <video controls src="<?php echo $_REQUEST['question_video']; ?>"
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
                                        <div id="quiz_question_video"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Video<span class="text-danger">*</span></label>
                                            <input type="file" name="quiz_question_video" class="form-control "/>
                                        </div>

                                        <div class="clearfix"></div>

                                        <input type="hidden" id="action_type" name="action_type"
                                               value="update_quiz_content">
                                        <input type="hidden" id="quiz_category_id" name="quiz_category_id"
                                               value="<?php echo $_REQUEST['category_id'] ?>">
                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">
                                        <input type="hidden" id="quiz_question_id" name="quiz_question_id"
                                               value="<?php echo (isset($_REQUEST['updateId'])) ? $_REQUEST['updateId'] : ''; ?>"/>
                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-danger btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
                                        </div>
                                        <div class="col-md-3">
                                            <a href="manage_quiz_content.php?serviceID='<?php echo $_REQUEST['quiz_id']; ?>'"
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

<?php if ((isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId)||(isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPoll_QuizId_ds)) { ?>
    <!--for datepicker loading-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#activation_date").click(function () {
                $(this).datepicker().datepicker('show');
            });
        });
    </script>
<?php } ?>

    <script type="text/javascript">
        $(document).ready(function () {

            $("#activation_date").click(function () {
                $(this).datepicker().datepicker('show');
            });

            //  $("#has_file").prop("checked", true);
            $("#quiz_question_image").hide();
            $("#quiz_question_audio").hide();
            $("#quiz_question_video").hide();

            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();

                $("#save_data").hide();
                $("#loading").show();

                var quiz_id = document.getElementById('quiz_id').value;
                var category_id = document.getElementById('category_id').value;
                // console.log(quiz_id);
                var myForm = document.getElementById('quiz_add_form');
                var form_data = new FormData(myForm);

                /*        for (var [key, value] of form_data.entries()) {
                            console.log('key', key);
                            if (value == 0 || value == '') {
                                alert(key + ' is empty');
                                var error = 1;
                                break;
                            }
                        }
                        if (error) {
                            $("#save_data").show();
                            $("#loading").hide();
                            return;
                        }*/
                console.log(form_data); //return;

                $.ajax({
                    url: "<?php echo $updateQuizContentApiUrl;?>",
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {
                                $("#save_data").show();
                                $("#loading").hide();
                                // alert(apires.status_msg);
                                <?php  $uri = PROJECT_BASE_PATH . "/content_management/manage_quiz_content.php";?>
                                window.location.replace('<?php echo $uri . "?category_id=";?>' + category_id + '&quiz_id=' + quiz_id);

                            } else {
                                alert(apires.status_msg);
                                $("#save_data").show();
                                $("#loading").hide();
                            }
                        } catch (e) {
                            alert("Error!!,Please see @console log.");
                            $("#save_data").show();
                            $("#loading").hide();
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

                $("#save_data").show();
                $("#loading").hide();
            });

            var url = '<?php echo $quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']; ?>';

            let dropdown = $('#category_id');
            dropdown.empty();
            dropdown.prop('selectedIndex', 0);

            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id'];?>';

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

            dropdown.prop('selectedIndex', 0);
            var url = '<?php echo $quizNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>' + '&quiz_category_id=' + category_id;

            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id'];?>';

                    $('option[value=' + theValue + ']')
                        .attr('selected', true);
                })
            });
        }

        function showImageField() {

            var checkBox = document.getElementById("has_image_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#quiz_question_image").show();

            } else {
                $("#quiz_question_image").hide();
            }
        }

        function showAudioField() {

            var checkBox = document.getElementById("has_audio_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#quiz_question_audio").show();

            } else {
                $("#quiz_question_audio").hide();
            }
        }

        function showVideoField() {

            var checkBox = document.getElementById("has_video_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#quiz_question_video").show();

            } else {
                $("#quiz_question_video").hide();
            }
        }
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>