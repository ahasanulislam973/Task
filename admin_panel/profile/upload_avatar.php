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

$pageTitle = "Avatar Upload Module ";
$tabActive = "profile";
$subTabActive = "upload_avatar";

$condition = '?abc=abc';

if (isset($_REQUEST['gender'])) {
    $condition .= "&gender=" . $_REQUEST['gender'];
}
$genderAvatarList = json_decode(file_get_contents($genderAvatarListUrl . $condition));
/*echo $genderAvatarListUrl . $condition;
print_r($genderAvatarList);
exit;*/
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;


?>
    <!-- select 2 css -->
    <!--dynamic table-->
    <link href="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_page.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo baseUrl('assets/modules/advanced-datatable/media/css/demo_table.css'); ?>" rel="stylesheet"/>
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

                                    <form accept-charset="utf-8" id="upload_content_form" enctype="multipart/form-data">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label for="role">Choose Gender <span class="text-danger">*</span></label>
                                            <select name="gender_name" id="gender_name" class="form-control smart_select "
                                                    >

                                                <option disabled selected value> -- Select an Option --</option>
                                                <option value="male">male</option>
                                                <option value="female">female</option>
                                                <?php if (isset($_REQUEST['gender_name'])) { ?> selected="selected" <?php } ?>
                                                
                                            </select>
                                        </div>
										
									 <div id="display_order"
											class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
											<label for="role">Display Order<span class="text-danger">*</span></label>
											<input name="display_order" type="number" min="1" class="form-control "
											placeholder="Enter Display Order" required/>
										</div>
										


                                        <div id="file" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Choose File<span class="text-danger">*</span> </label>
                                            <input type="file" name="file[]" id="file" multiple>
                                        </div>


                                        <input type="hidden" name="user_id" id="user_id"
                                               value="<?php echo(isset($_SESSION['admin_login_info']['user_id']) ? $_SESSION['admin_login_info']['user_id'] : '') ?>"/>

                                        <div class="clearfix"></div>

                                        <div class="col-md-3" id="save_data_btn">
                                            <input type="submit" class="btn btn-danger btn-block btn-sm"
                                                   name="save_data" id="save_data"
                                                   value="Save">
                                        </div>


                                        <div class="adv-table">
                                            <table class="display table table-bordered" id="my_data_table">

                                                <thead>
                                                <tr class="">
                                                    <th width="12%">Display Order</th>
                                                    <th width="18%">Gender </th>
                                                    <th width="20%">Avatar</th>
                                                    <th width="10%">SL</th>
                                                    <th width="20%">Entry Time</th>
                                                    <th width="20%">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($genderAvatarList)) { ?>
                                                    <?php

                                                    foreach ($genderAvatarList as $key => $row) {

                                                        $gender_name = !empty($row->gender_name) ? $row->gender_name : NULL;
                                                        $avatarID = !empty($row->id) ? $row->id : NULL;
                                                        $display_order = !empty($row->display_order) ? $row->display_order : NULL;
                                                        $updateUrl = baseUrl('profile/update_avatar.php?updateId=' . $avatarID);

                                                        $deleteUrl = baseUrl('profile/delete_avatar.php?deleteId=' . $avatarID);
                                                        $avatar_list = !empty($row->avatar_list) ? $row->avatar_list : "";

                                                        $created = longDateHuman($row->entry_time, 'date_time');

                                                        $updateUrl .= "&display_order=$display_order&gender_name=$gender_name&avatar_list=$avatar_list";
                                                        
                                                        ?>
                                                        <tr class="">
                                                            <td><?php echo $display_order; ?></td>
                                                            <td><?php echo $gender_name; ?></td>

                                                            <td><?php if ($avatar_list <> '') { ?><a
                                                                    href="<?php echo $avatar_list; ?>" target="_blank">
                                                                    <img
                                                                            src=" <?php echo $avatar_list; ?> "
                                                                            width="50"
                                                                            height="60"/>
                                                                    </a>
                                                                <?php } else echo 'NA'; ?></td>
                                                            <td><?php echo $avatarID; ?></td>
                                                            <td><?php echo $created; ?></td>

                                                            <td class="">
                                                                <a class="btn btn-primary btn-xs" title="Update"
                                                                   href="<?php echo $updateUrl; ?>"><i
                                                                            class="fa fa-edit"></i></a>
                                                                <a class="btn btn-danger btn-xs" title="Delete"
                                                                   onclick="return confirm('Are you Sure??\nYou Want to Delete this item!');"
                                                                   href="<?php echo $deleteUrl; ?>">
                                                                    <i class="fa fa-ban"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                                </tbody>
                                            </table>

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
    <!--Dynamic Data Table-->
    <script type="text/javascript" language="javascript"
            src="<?php echo baseUrl('assets/modules/advanced-datatable/media/js/jquery.dataTables.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo baseUrl('assets/modules/data-tables/DT_bootstrap.js'); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            /*
            $('#my_data_table').dataTable({

                order: [[3, "asc"]]
            });
            */

		/*	 var url = '<?php echo $avatarDisplayOrderUrl;?>';
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
                //populateQuiz();
            });
			
			*/

            $(document).on('click', '#save_data', function (event) {
                event.preventDefault();
                this.disabled = true;
				
				var gender_name = document.getElementById('gender_name').value;
				
                var myForm = document.getElementById('upload_content_form');
                var form_data = new FormData(myForm);
                $("#save_data").hide();
                for (var [key, value] of form_data.entries()) {
                    console.log(key, value);
                }
                showLoader();
                console.log(form_data); //return;

                $.ajax({
                    url: "../../bot_service_api/fileUploaderAvatar.php",
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
								
								 <?php  $uri = PROJECT_BASE_PATH . "/profile/upload_avatar.php?gender_name=";?>
                                 window.location.replace('<?php echo $uri;?>' + gender_name);
								
				 
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

        function showLoader() {
            $('#loading').show();
            $('save_data').disabled = true;
        };

    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>