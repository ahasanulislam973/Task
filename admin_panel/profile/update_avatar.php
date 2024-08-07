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

$pageTitle = "Avatar Modification";
$tabActive = "profile";
$subTabActive = "upload_avatar";
$avatarUploadUrl = $redirectUrl = baseUrl("profile/upload_avatar.php");
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;


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
                              <a href="<?php echo $avatarUploadUrl; ?>" class=" btn btn-success btn-xs"> Avatar Upload Module</a>
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
                                    <form accept-charset="utf-8" id="avatar_add_form" enctype="multipart/form-data">


                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Gender <span class="text-danger">*</span></label>
                                            <select name="gender_name" id="gender_name" class="form-control smart_select ">

                                                <option disabled selected value> -- Select an Option --</option>
                                                <option  <?php if (isset($_REQUEST['gender_name'])&&$_REQUEST['gender_name']=='male') echo 'selected' ; ?> value="male">male</option>
                                                <option <?php if (isset($_REQUEST['gender_name'])&&$_REQUEST['gender_name']=='female') echo 'selected' ; ?> value="female">female</option>

                                            </select>
                                        </div>
										
										
										 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Enter Display Order <span class="text-danger">*</span> </label>
                                            <input type="text" placeholder="Enter Display Order" name="display_order"
                                                   class="form-control"
                                                   value="<?php echo $_REQUEST['display_order']; ?>">
                                        </div>


                                        <div class="clearfix"></div>

                                        <div id="quiz_question_image_prev"
                                             class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <label for="role"><img src="<?php echo $_REQUEST['avatar_list']; ?>"
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
                                        <div id="avatar_image"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="avatar_image" class="form-control "/>
                                        </div>


                                        <div class="clearfix"></div>

                                        <input type="hidden" id="action_type" name="action_type"
                                               value="update_quiz_content">
                                        <input type="hidden" id="gender_name" name="gender_name"
                                               value="<?php echo $_REQUEST['gender_name'] ?>">


                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">
                                        <input type="hidden" id="updateId" name="updateId"
                                               value="<?php echo (isset($_REQUEST['updateId'])) ? $_REQUEST['updateId'] : ''; ?>"/>
                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-danger btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
                                        </div>
                                        <div class="col-md-3">
                                            <a href="upload_avatar.php?updateId='<?php echo $_REQUEST['updateId']; ?>'"
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
            $("#avatar_image").hide();

            var url = '<?php echo $avatarDisplayOrderUrl;?>';
            let dropdown = $('#display_order');
            dropdown.empty();
            dropdown.append('<option  disabled>Choose Display Order</option>');
            dropdown.prop('selectedIndex', 0);
            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['display_order'])) echo $_REQUEST['display_order'];?>';
                    // alert('catid=' + theValue);
                    $('option[value=' + theValue + ']')
                        .attr('selected', true);
                })

            });


            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();

                $("#save_data").hide();
                $("#loading").show();


                var gender_name = document.getElementById('gender_name').value;
                console.log(gender_name);
              //  alert(gender_name); retrun;

                var myForm = document.getElementById('avatar_add_form');
                var form_data = new FormData(myForm);

               /* for (var [key, value] of form_data.entries()) {
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
             */
                var target_url='<?php echo $updateAvatarApiUrl ; ?>';
                //alert(target_url);

                $.ajax({
                    //  url: "../../BOT/api/updateQuizContent.php",
                    url: target_url,
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {
                                $("#save_data").show();
                                $("#loading").hide();
                                alert(apires.status_msg);

                                <?php  $uri = PROJECT_BASE_PATH . "/profile/upload_avatar.php?gender_name=";?>
                                window.location.replace('<?php echo $uri;?>' + gender_name);


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




        });


        function showImageField() {

            var checkBox = document.getElementById("has_image_file");

            if (checkBox.checked == true) { // if service name is quiz
                // console.log(conceptName);
                $("#avatar_image").show();

            } else {
                $("#avatar_image").hide();
            }
        }

    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>