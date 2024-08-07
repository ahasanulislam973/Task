<?php
session_start();
//require_once '../config/config.php';

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

$pageTitle = "Modify Quiz";
$tabActive = "services_management";
$subTabActive = "edit_quiz";
$manageQuizUrl = $redirectUrl = baseUrl("services_management/manage_quiz.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

$organizations = getOrganization();
//$categoryName = populateQuizCategory();
$categoryName = json_decode(file_get_contents($quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));


?>
    <!-- select 2 css -->
    <link href="<?php echo baseUrl('assets/css/select2.min.css'); ?>" rel="stylesheet">

    //added for datetime range
    <link rel="stylesheet" href="../assets/js/dist/daterangepicker.min.css"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js" type="text/javascript"></script>
    <script src="../assets/js/dist/jquery.daterangepicker.js"></script>

    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $manageQuizUrl; ?>" class=" btn btn-success btn-xs"> Manage Quiz</a>
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

                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Quiz Category <span
                                                        class="text-danger">*</span></label>
                                            <select name="quiz_category" class="form-control smart_select ">
                                                <?php foreach ($categoryName as $key => $val) { ?>
                                                    <option value="<?php echo $key ?>"
                                                        <?php if (isset($_REQUEST['quiz_category']) && $_REQUEST['quiz_category'] == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Name/Title <span class="text-danger">*</span></label>
                                            <input name="quiz_name" class="form-control "
                                                   placeholder="Write Quiz Name/Title"
                                                   value="<?php echo (isset($_REQUEST['quiz_title'])) ? $_REQUEST['quiz_title'] : ''; ?>"
                                            />
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="quiz_description"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Description <span
                                                        class="text-danger">*</span></label>
                                            <textarea class="form-control"
                                                      name="quiz_description"><?php echo (isset($_REQUEST['quiz_description'])) ? ltrim($_REQUEST['quiz_description']) : ''; ?></textarea>
                                        </div>
                                        <div id="quiz_image_view"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <a href="<?php echo $_REQUEST['quiz_image']; ?>" target="_blank">
                                                <img
                                                        src="<?php echo $_REQUEST['quiz_image']; ?>"
                                                        alt="no image"
                                                        width="150"
                                                        height="80"
                                                        style="max-width:95%;border:3px solid black;"
                                                >
                                            </a>

                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-8">

                                            <label class="label_check c_on" for="has_file">
                                                <input type="checkbox" name="has_file" id="has_file" value="yes"
                                                       onclick="showFilesField();">
                                                Wish to Change this Image</label>
                                        </div>


                                        <div class="clearfix"></div>

                                        <div id="question_limit"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Question Limit<span class="text-danger">*</span></label>
                                            <input name="question_limit" type="number" min="1" class="form-control "
                                                   placeholder="Enter Question Limit"
                                                   value="<?php echo (isset($_REQUEST['question_limit'])) ? $_REQUEST['question_limit'] : ''; ?>"
                                            />
                                        </div>

                                        <div id="question_benchmark"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Benchmark Score<span class="text-danger">*</span></label>
                                            <input name="question_benchmark" type="number" min="1" class="form-control"
                                                   placeholder="Enter Benchmark Score" required
                                                   value="<?php echo (isset($_REQUEST['Bench_mark_point'])) ? $_REQUEST['Bench_mark_point'] : ''; ?>"
                                            />
                                        </div>
                                        <div class="clearfix"></div>

                                        <div id="quiz_status_div"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Status<span class="text-danger">*</span></label>
                                            <select name="quiz_status" class="form-control smart_select"/>
                                            <option value="Active"
                                                <?php if (isset($_REQUEST['quiz_status']) && $_REQUEST['quiz_status'] == "Active") { ?> selected="selected" <?php } ?>>
                                                Active
                                            </option>
                                            <option value="Inactive"
                                                <?php if (isset($_REQUEST['quiz_status']) && $_REQUEST['quiz_status'] == "Inactive") { ?> selected="selected" <?php } ?>>
                                                Inactive
                                            </option>
                                            <option value="live"
                                                <?php if (isset($_REQUEST['quiz_status']) && $_REQUEST['quiz_status'] == "live") { ?> selected="selected" <?php } ?>>
                                                Live
                                            </option>
                                            <option value="ended"
                                                <?php if (isset($_REQUEST['quiz_status']) && $_REQUEST['quiz_status'] == "ended") { ?> selected="selected" <?php } ?>>
                                                Ended
                                            </option>

                                            </select>

                                        </div>
                                        <div id="quiz_image" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="quiz_image" class="form-control "/>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div id="quiz_charge"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Charge (Any Currency)<span
                                                        class="text-danger">*</span></label>
                                            <input name="quiz_charge" type="number" min="1.22" max="60.00" step="1.22"
                                                   class="form-control"
                                                   value="<?php if (isset($_REQUEST['quiz_charge'])) echo $_REQUEST['quiz_charge']; ?>"
                                            />

                                        </div>
										
										
										  <div id="ghoori_marchant_id" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Marchant Package ID </label>
                                            <input name="ghoori_marchant_id" class="form-control "
                                                   placeholder="Enter the ghoori marchant package id here"
                                                   value="<?php echo (isset($_REQUEST['ghoori_marchant_id'])) ? $_REQUEST['ghoori_marchant_id'] : ''; ?>"
                                            />

                                        </div>
										
				
										 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Quiz Type <span
                                                        class="text-danger">*</span></label>
                        			
											<select name="quiz_type" class="form-control smart_select " value="<?php if (isset($_REQUEST['quiz_type'])) echo $_REQUEST['quiz_type']; ?>">
											  <option value="free" <?php if (isset($_REQUEST['quiz_type']) && $_REQUEST['quiz_type'] == "free") { ?> selected="selected" <?php } ?>>
											  free
											  </option>
											  <option value="paid"  <?php if (isset($_REQUEST['quiz_type']) && $_REQUEST['quiz_type'] == "paid") { ?> selected="selected" <?php } ?>>paid</option>
											
											</select>
                                        </div>
										
										
										<div class="clearfix"></div>
										 <div id="quiz_rules"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Rules <span
                                                        class="text-danger">*</span></label>
                                            <!--<textarea name="quiz_rules" class="form-control"
                                                      placeholder="Enter quiz rules(text)" required>  </textarea>-->
													  <textarea class="form-control"
                                                      name="quiz_rules"><?php echo (isset($_REQUEST['quiz_rules'])) ? ltrim($_REQUEST['quiz_rules']) : ''; ?></textarea>
                                        </div>
										
										
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">
                                                Set Date Range </label>

                                            <input class="form-control" type="text"
                                                   name="date_time_range" id="date_time_range" autocomplete="off"
                                                   value="<?php echo $_REQUEST['start_date'];
                                                   echo "-";
                                                   echo $_REQUEST['start_date']; ?>"/>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div id="star_time"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label id="l_start_date"
                                                   class="text-danger">Quiz Start
                                                Time: <?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?></label>
                                        </div>
                                        <div id="end_time"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label id="l_end_date"
                                                   class="text-danger">Quiz End
                                                Time: <?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?></label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="hidden" id="start_date" name="start_date"
                                               value="<?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?>">
                                        <input type="hidden" id="end_date" name="end_date"
                                               value="<?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?>">
                                        <input type="hidden" id="action_type" name="action_type" value="update_quiz">

                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">
                                        <input type="hidden" id="quiz_id" name="quiz_id"
                                               value="<?php echo (isset($_REQUEST['updateId'])) ? $_REQUEST['updateId'] : ''; ?>"/>
                                        <div class="col-md-3">
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

            $("#has_file").prop("checked", false);

            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();
                $("#save_data").hide();
                var myForm = document.getElementById('quiz_add_form');
                var form_data = new FormData(myForm);

                for (var [key, value] of form_data.entries()) {
                    console.log('key', key);
                    if ( value == '') {
                        alert(key + ' is empty');
                        var error = 1;
                        break;
                    }
                }
                if (error) {
                    $("#loading").hide();
                    $("#save_data").show();
                    return;
                }
                console.log(form_data); //return;

                $.ajax({
                    // url: "../../BOT/api/addQuiz.php",
                    url: '<?php echo $addQuizApiUrl;?>',
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {
                                $("#save_data").show();
                                $("#loading").hide();
                                $('#quiz_add_form')[0].reset();
                                alert(apires.status_msg);
                                window.location.assign("/bot_service_panel/services_management/manage_quiz.php?quiz_category_id=<?php echo $_REQUEST['quiz_category'];?>");
                            } else {
                                $("#save_data").show();
                                $("#loading").hide();
                                alert(apires.status_msg);

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

        function showFilesField() {

            var checkBox = document.getElementById("has_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#quiz_image").show();

            } else {
                $("#quiz_image").hide();
            }
        }

        $(function () {

            $('#date_time_range').dateRangePicker(
                {
                    startOfWeek: 'sunday',
                    separator: ' ~ ',
                    format: 'YYYY-MM-DD HH:mm:ss',
                    autoClose: false,
                    time: {
                        enabled: true
                    }
                })

            $('input[name="date_time_range"]').on('datepicker-closed', function () {

                var rang = document.getElementById("date_time_range").value;
                console.log(rang);
                var res = rang.split(" ~ ");
                var start_date = document.getElementById('start_date');
                start_date.value = res[0];
                var end_date = document.getElementById('end_date');
                end_date.value = res[1];
                document.getElementById("l_start_date").innerHTML = 'Quiz Start Time: ' + '<mark>' + res[0];
                +'</mark>';
                document.getElementById("l_end_date").innerHTML = 'Quiz End Time: ' + '<mark>' + res[1];
                +'</mark>';
            });


        });
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>