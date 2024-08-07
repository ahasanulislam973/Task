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

$pageTitle = "Create New Quiz/On-Demand Service Category";
$tabActive = "services_management";
$subTabActive = "add_category";
$organizations = getOrganization();
$manageCategoryUrl = $redirectUrl = baseUrl("services_management/manage_category.php");
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
                              <a href="<?php echo $manageCategoryUrl; ?>" class=" btn btn-success btn-xs"> Manage Category</a>
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
                                    <form accept-charset="utf-8" id="quiz_category_add_form"
                                          enctype="multipart/form-data">

                                        <?php if ($_SESSION['admin_login_info']['organization_id'] == 0) { ?>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label for="organization">Organization/Operator <span class="text-danger">(Except Super Power)*</span></label>
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

                                        <div id="quiz_category_name"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Quiz Category Name <span
                                                        class="text-danger">*</span></label>
                                            <input name="quiz_category_title" class="form-control "
                                                   placeholder="Write Quiz Category Name" required/>

                                        </div>
                                        <div id="quiz_category_image"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Chose Image<span class="text-danger">*</span></label>
                                            <input type="file" name="category_image" class="form-control "
                                                   required/>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div id="quiz_category_description"
                                             class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Category Description <span
                                                        class="text-danger">*</span></label>
                                            <textarea name="category_description" class="form-control"
                                                      placeholder="Write Quiz Category Description"
                                                      required>  </textarea>
                                        </div>

                                        <div class="clearfix"></div>
                                        <input type="hidden" id="action_type" name="action_type"
                                               value="insert_category">
                                        <input type="hidden" id="user_id" name="user_id"
                                               value="<?php echo $_SESSION['admin_login_info']['user_id']; ?>">

                                        <div class="col-md-3">
                                            <input type="submit" class="btn btn-success btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
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

                var myForm = document.getElementById('quiz_category_add_form');
                var form_data = new FormData(myForm);

                for (var [key, value] of form_data.entries()) {
                    console.log(key, value);
                    if (value == 0 || value == '') {
                        alert(key.replace('_', ' ') + ' is empty');
                        var error = 1;
                        break;
                    }
                }
                if (error) {
                    return;
                }

                console.log(form_data); //return;

                $.ajax({
                    //   url: "../../BOT/api/addCategory.php",
                    url: '<?php echo $addCategoryApiUrl;?>',
                    method: "POST",
                    data: form_data,
                    success: function (data) {
                        console.log(data);

                        try {
                            var apires = JSON.parse(data);
                            if (apires.status_code == '200') {

                                $('#quiz_category_add_form')[0].reset();

                                alert(apires.status_msg);

                            } else {
                                alert(apires.status_msg);

                            }
                        } catch (e) {
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


    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>