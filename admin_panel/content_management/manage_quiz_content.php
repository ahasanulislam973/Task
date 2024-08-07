<?php
session_start();
//require_once '../config/config.php';
require_once '../lib/functions.php';
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

$pageTitle = "Manage Quiz Questions";
$tabActive = "content_management";
$subTabActive = "manage_quiz_content";
$uploadContentUrl = baseUrl('content_management/bulk_upload.php');

$condition = "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];
if (isset($_REQUEST['category_id'])) {
    $condition .= "&category_id=" . $_REQUEST['category_id'];
}
if (isset($_REQUEST['quiz_id'])) {
    $condition .= "&quiz_id=" . $_REQUEST['quiz_id'];
}
$quizContentList = json_decode(file_get_contents($quizContentListUrl . $condition));


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
                            <span class="pull-right">
                              <a href="<?php echo $uploadContentUrl; ?>"
                                 class=" btn btn-success btn-xs"> Upload Content</a>
                          </span>
                        </header>

                        <div class="panel-body">

                            <div id="quiz_category" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Category Name<span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                        class="form-control smart_select quiz_category_id"
                                        onchange="populateQuiz()">
                                    <?php if (isset($_REQUEST['category_id'])) { ?> selected="selected" <?php } ?>>

                                </select>
                            </div>

                            <div id="quiz_name" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="role">Quiz Name <span class="text-danger">*</span></label>
                                <select name="quiz_name" id="quiz_id"
                                        class="form-control smart_select quiz_name" onchange="getQuizContent(this);">
                                    <?php if (isset($_REQUEST['quiz_id'])) { ?> selected="selected" <?php } ?>>
                                </select>
                            </div>

                            <div class="adv-table">
                                <table class="display table table-bordered table-responsive" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="5%">Category</th>
                                        <th width="5%">QuizName</th>
                                        <th width="5%">Image</th>
                                        <th width="5%">Audio</th>
                                        <th width="5%">Video</th>
                                        <th width="15%">Text</th>
                                        <th width="10%">Options</th>
                                        <th width="5%">Ans.</th>
                                        <th width="5%">Point</th>
                                        <th width="5%">Status</th>

                                        <?php if ((isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId_ProthomAlo)||(isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPoll_QuizId_ds)) { // HIMALAYAN TIMES VOTING POLL ?>
                                            <th width="5%">ActivationDate</th>
                                        <?php } ?>
                                        <th width="5%">UpdatedBy</th>
                                        <th width="5%">UpdatedAt</th>
                                        <th width="5%">CreatedBy</th>
                                        <th width="5%">CreatedAt</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($quizContentList)) { ?>
                                        <?php

                                        foreach ($quizContentList as $key => $row) {

                                            $quiz_category_name = !empty($row->quiz_category_name) ? $row->quiz_category_name : NULL;
                                            $quiz_category_id = !empty($row->quiz_category_id) ? $row->quiz_category_id : NULL;
                                            $quiz_title = !empty($row->quiz_title) ? $row->quiz_title : NULL;
                                            $question_id = !empty($row->question_id) ? $row->question_id : NULL;
                                            $quiz_id = !empty($row->quiz_id) ? $row->quiz_id : NULL;
                                            $updateUrl = baseUrl('content_management/update_quiz_content.php?updateId=' . $question_id);

                                            // $deleteUrl = baseUrl('content_management/delete_quiz_content.php?deleteId=' . $question_id);
                                            $deleteUrl = baseUrl('content_management/delete_quiz_content.php?deleteId=' . $question_id . '&qid=' . $quiz_id . '&cid=' . $quiz_category_id);
                                            $question_image = !empty($row->question_image) ? $row->question_image : "";
                                            $question_audio = !empty($row->question_audio) ? $row->question_audio : "";
                                            $question_video = !empty($row->question_video) ? $row->question_video : "";
                                            $question_text = !empty($row->question_text) ? $row->question_text : "";
                                            $question_option = !empty($row->question_option) ? $row->question_option : "";

                                            $tableName = 'quiz_question';
                                            $activationDate = '';
                                            if ((isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId_ProthomAlo)||(isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPoll_QuizId_ds)) {
                                                $activationDate = !empty($row->activation_date) ? $row->activation_date : "";
                                                $tableName = 'ondemand_quiz_question';
                                            }

                                            if (strpos($question_option, '[') !== false) {
                                                $question_option = str_ireplace('[', '', $question_option);
                                                $question_option = str_ireplace(']', '', $question_option);
                                                $question_option = str_ireplace('"', '', $question_option);
                                                $question_option = str_ireplace(',', ';', $question_option);
                                            } else {
                                                $optionArray = json_decode($question_option);
                                                $optionKeyArray = array();
                                                $optionValueArray = array();
                                                foreach ($optionArray as $key => $value) {
                                                    $optionKeyArray[] = $key;
                                                    $optionValueArray[] = $value;
                                                }
                                                $strkey = implode(',', $optionKeyArray);
                                                $strValue = implode(',', $optionValueArray);
                                                $question_option = $strkey . ";" . $strValue;
                                            }
                                            $question_ans = !empty($row->question_ans) ? $row->question_ans : "";
                                            $question_point = !empty($row->question_point) ? $row->question_point : "";
                                            $question_status = !empty($row->question_status) ? $row->question_status : "";

                                            $updated_by = !empty($row->updated_by) ? $row->updated_by : "";
                                            $updated_at = longDateHuman($row->updated_at, 'date_time');
                                            $createdBy = !empty($row->created_by) ? $row->created_by : "";
                                            $created = longDateHuman($row->created_at, 'date_time');

                                            $value = "&category_id=$quiz_category_id&quiz_id=$quiz_id&question_image=$question_image&question_audio=$question_audio&question_video=$question_video&";
                                            $value .= "&question_text=$question_text&question_ans=" . urlencode($question_ans) . "&question_point=$question_point&question_status=$question_status&question_option=" . urlencode($question_option);
                                            $value .= '&table=' . $tableName . '&activation_date=' . $activationDate;
                                            $updateUrl .= $value;

                                            $pushUrl = baseUrl('content_management/push_quiz_content.php?pushId=' . $question_id);
                                            $pushUrl .= "&jsonData=" . urlencode(json_encode($row));

                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $quiz_category_name; ?></td>
                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $quiz_title; ?></a>
                                                </td>
                                                <td> <?php if ($question_image <> '') { ?><a
                                                        href="<?php echo $question_image; ?>" target="_blank"> <img
                                                                src=" <?php echo $question_image; ?> " width="50"
                                                                height="60"/>
                                                        </a>
                                                    <?php } else echo 'NA'; ?>
                                                </td>
                                                <td> <?php if ($question_audio <> '') { ?>
                                                    <audio controls src="<?php echo $question_audio; ?>"
                                                           alt="No Audio"
                                                           width="150"
                                                           height="80"
                                                           style="max-width:95%;border:3px solid black;">
                                                            <code>audio</code>
                                                        </audio><?php } else echo 'NA'; ?>
                                                </td>
                                                <td> <?php if ($question_video <> '') { ?>
                                                    <video controls src="<?php echo $question_video; ?>"
                                                           alt="no image"
                                                           width="150"
                                                           height="80"
                                                           style="max-width:95%;border:3px solid black;">
                                                        </video><?php } else echo 'NA'; ?>
                                                </td>
                                                <td><?php echo $question_text; ?></td>
                                                <td><?php echo $question_option; ?></td>
                                                <td><?php echo $question_ans; ?></td>
                                                <td><?php echo $question_point; ?></td>
                                                <td> <?php if ($question_status == 'Que') echo '<span class="btn btn-danger btn-xs">'; elseif ($question_status == 'Active') echo '<span class="btn btn-success btn-xs">';
                                                    else echo '<span class="btn btn-primary btn-xs">';
                                                    echo $question_status;
                                                    if ($question_status == 'Que') {
                                                        ?>
                                                        </span>
                                                        <a class="btn btn-primary btn-xs" title="Push"
                                                           onclick="return confirm('Are you Sure??\nYou Want to Push this item!');"
                                                           href="<?php echo $pushUrl; ?>">
                                                            <i class="fa fa-mail-forward"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>

                                                <?php if ((isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPollQuizId_ProthomAlo)||(isset($_REQUEST['quiz_id']) && $_REQUEST['quiz_id'] == $votingPoll_QuizId_ds)) { ?>
                                                    <td><?php echo $activationDate; ?></td>
                                                <?php } ?>
                                                <td><?php echo $updated_by; ?></td>
                                                <td><?php echo $updated_at; ?></td>
                                                <td><?php echo $createdBy; ?></td>
                                                <td><?php echo $created; ?></td>

                                                <td class="">
                                                    <a class="btn btn-primary btn-xs" title="Update"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-xs" title="Delete"
                                                       onclick="return confirm('Are you Sure?\nYou Want to Delete this item!');"
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

            var url = '<?php echo $quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>';
            let dropdown = $('#category_id');
            dropdown.empty();
            /* dropdown.append('<option  disabled>Choose Category</option>');*/
            dropdown.prop('selectedIndex', 0);
            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['category_id'])) echo $_REQUEST['category_id'];?>';
                    // alert('catid=' + theValue);
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
            /*     dropdown.append('<option  disabled>Choose Quiz</option>');*/
            dropdown.prop('selectedIndex', 0);
            var url = '<?php if ($_SESSION['admin_login_info']['organization_id'] == 6) {
                $quizNameUrl = $quizNameAppUrl;
            } echo $quizNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id'];?>' + '&quiz_category_id=' + category_id;

            // Populate dropdown with list of provinces
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                    console.log('key', key, 'value', entry);
                    var theValue = '<?php if (isset($_REQUEST['quiz_id'])) echo $_REQUEST['quiz_id'];?>';
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
            var category_id = $('.quiz_category_id option:selected').val();
            //  alert('catid=' + category_id);
            //  alert('quizid=' + x);
            <?php  $uri = PROJECT_BASE_PATH . "/content_management/manage_quiz_content.php?quiz_id=";?>
            window.location.replace('<?php echo $uri;?>' + x + "&category_id=" + category_id);
        }
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>