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

$pageTitle = "Create Quiz";
$tabActive = "services_management";
$subTabActive = "add_quiz";
$addCategoryUrl = $redirectUrl = baseUrl("services_management/add_category.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;
$organizations = getOrganization();
//$categoryName = populateQuizCategory();
$categoryName = json_decode(file_get_contents($quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']), true);


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
                              <a href="<?php echo $addCategoryUrl; ?>" class=" btn btn-success btn-xs"> Add Category</a>
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
                                                        <?php if (isset($_POST['save']) && $_POST['service_name'] == $key) { ?> selected="selected" <?php } ?>>
                                                        <?php echo $val; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Name/Title <span class="text-danger">*</span></label>
                                           <!-- <input name="quiz_name" class="form-control "
                                                   placeholder="Write Quiz Name/Title" required/>-->
												   <textarea name="quiz_name" class="form-control" onkeyup="textCounter(this,'counter3',40);"
                                             placeholder="Enter the carousel title here.. (limited to 40 characters)" required></textarea>
										<input  disabled  maxlength="20"  size="20" value="Remaining characters:40" id="counter3">

                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="quiz_description"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Description <span
                                                        class="text-danger">*</span></label>
                                            <!-- <textarea name="quiz_description" class="form-control"
                                                      placeholder="Write Quiz Description" required>  </textarea> -->
													  
											
											<textarea name="quiz_description" class="form-control" onkeyup="textCounter(this,'counter',80);"
                                             placeholder="Enter the carousel subtitle here.. (limited to 80 characters)" required></textarea>
										<input  disabled  maxlength="20"  size="20" value="Remaining characters:80" id="counter">
                                        </div>

                                        <div id="quiz_image" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="quiz_image" class="form-control " required/>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="question_limit"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Question Limit<span class="text-danger">*</span></label>
                                            <input name="question_limit" type="number" min="1" class="form-control "
                                                   placeholder="Enter Question Limit" required/>
                                        </div>

                                        <div id="question_benchmark"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Benchmark Score<span class="text-danger">*</span></label>
                                            <input name="question_benchmark" type="number" min="1.00" step="0.50"
                                                   class="form-control"
                                                   placeholder="Enter Benchmark Score" required/>

                                        </div>
										
										<div class="clearfix"></div>
										
										     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Quiz Type <span
                                                        class="text-danger">*</span></label>
                        			
											<select name="quiz_type" class="form-control smart_select ">
											  <option value="free">free</option>
											  <option value="paid">paid</option>
											
											</select>
                                        </div>
									
                                        <div id="quiz_charge"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Charge(Any Currency)<span
                                                        class="text-danger">*</span></label>
                                            <input name="quiz_charge" type="number" min="0" max="60.00" step="1:22"
                                                   class="form-control"
                                                   placeholder="Quiz Charge i.e:10 BDT" required/>

                                        </div>

										<div class="clearfix"></div>
										
								
										 <div id="quiz_rules"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Rules <span
                                                        class="text-danger">*</span></label>
                                           <!--<textarea name="quiz_rules" class="form-control"
                                                      placeholder="Enter quiz rules(text)" required></textarea>-->
													  
													  <textarea name="quiz_rules" class="form-control" onkeyup="textCounter(this,'counter1',500);"
                                             placeholder="Enter the quiz rules here.. (limited to 500 characters)" required></textarea>
										<input  disabled  maxlength="20"  size="20" value="Remaining characters:500" id="counter1">
                                        </div>
										
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">
                                                Select Date Time Range </label>

                                            <input class="form-control" type="text"
                                                   name="date_time_range" id="date_time_range" autocomplete="off"/>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="star_time"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label id="l_start_date"></label>
                                        </div>
                                        <div id="end_time"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label id="l_end_date"></label>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="hidden" id="start_date" name="start_date"
                                               value="<?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?>">
                                        <input type="hidden" id="end_date" name="end_date"
                                               value="<?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?>">
                                        <input type="hidden" id="action_type" name="action_type" value="insert_quiz">

                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">

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


            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();
                $("#save_data").hide();
                var myForm = document.getElementById('quiz_add_form');
                var form_data = new FormData(myForm);

                for (var [key, value] of form_data.entries()) {
                    console.log(key, value);
                    if (value == '') {
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
                    //url: "../../BOT/api/addQuiz.php",
                    url: '<?php echo $addQuizApiUrl;?>',
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {

                                $('#quiz_add_form')[0].reset();
                                $("#save_data").show();
                                $("#loading").hide();
                                alert(apires.status_msg);

                            } else {
                                $("#save_data").show();
                                $("#loading").hide();
                                alert(apires.status_code,apires.status_msg);
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
            //(@copyright By Al-Amin) Below commented section is for information and scope for get data and state of picker.

            /*
                    .on('datepicker-first-date-selected', function (event, obj) {
                            /!* This event will be triggered when first date is selected *!/
                            console.log('first-date-selected', obj);
                        })
                            .on('datepicker-change', function (event, obj) {
                                /!* This event will be triggered when second date is selected *!/
                                console.log('change', obj);
                            })
                            .on('datepicker-apply', function (event, obj) {
                                /!* This event will be triggered when user clicks on the apply button *!/
                                console.log('apply', obj);
                                // console.log(obj.value);
                            })
                            .on('datepicker-close', function () {
                                /!* This event will be triggered before date range picker close animation *!/
                                console.log('before close');
                            })
                            .on('datepicker-closed', function () {
                                /!* This event will be triggered after date range picker close animation *!/
                                console.log('after close');

                            })
                            .on('datepicker-open', function () {
                                /!* This event will be triggered before date range picker open animation *!/
                                console.log('before open');
                            })
                            .on('datepicker-opened', function () {
                                /!* This event will be triggered after date range picker open animation *!/
                                console.log('after open');
                            });
                            */

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
		
	
function textCounter(field,field2,maxlimit)
{
 var countfield = document.getElementById(field2);
 if ( field.value.length > maxlimit ) {
  field.value = field.value.substring( 0, maxlimit );
  return false;
 } else {
  countfield.value = "Remaining characters: " + (maxlimit - field.value.length);
 }
}


    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>