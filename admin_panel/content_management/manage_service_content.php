<?php
session_start();
require_once '../config/config.php';
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

$serviceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));

$pageTitle = "Manage Service Content";
$tabActive = "content_management";
$subTabActive = "manage_service_content";
$uploadContentUrl = baseUrl('content_management/bulk_upload.php');

$condition = '';
$_SESSION['successMsg'] = '';

if (isset($_REQUEST['serviceID']) && $_REQUEST['serviceID'] <> '') {
    $condition = "?serviceID=" . $_REQUEST['serviceID'];
    $_SESSION['successMsg'] .= " Service Name $_REQUEST[serviceID]";
}


$serviceContentList = json_decode(file_get_contents($serviceContentListUrl . $condition));

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

                    <?php if (isset($_SESSION['successMsg']) && $_SESSION['successMsg'] <> '') {
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
                                 class=" btn btn-success btn-xs"> Upload content</a>
                          </span>
                        </header>

                        <div class="panel-body">
                            <form accept-charset="utf-8" id="category_form" enctype="multipart/form-data">

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="role">Select Service<span class="text-danger">*</span></label>
                                    <select name="quiz_category" id="quiz_category" class="form-control smart_select "
                                            onchange="getService(this);">
                                        <?php foreach ($serviceName as $key => $val) { ?>
                                            <option value="<?php echo $key ?>"
                                                <?php if (isset($_REQUEST['serviceID']) && $_REQUEST['serviceID'] == $key) { ?> selected="selected" <?php } ?>>
                                                <?php echo $val; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </form>

                            <div class="adv-table">
                                <table class="display table table-bordered" id="my_data_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="5%">Content ID</th>
                                        <th width="10%">Service</th>
                                        <th width="5%">Category</th>
                                        <th width="5%">Image</th>
                                        <th width="10%">Audio</th>
                                        <th width="10%">Video</th>
                                        <th width="20%">Text</th>
                                        <th width="5%">Status</th>
                                        <th width="5%">Activation Date</th>
                                        <th width="5%">Deactivation Date</th>

                                        <th width="5%">Updated By</th>
                                        <th width="5%">Updated At</th>
                                        <th width="5%">Created By</th>
                                        <th width="5%">Created At</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($serviceContentList)) { ?>
                                        <?php

                                        foreach ($serviceContentList as $key => $row) {

                                            $ContentID = !empty($row->ContentID) ? $row->ContentID : NULL;
                                            $ServiceID = !empty($row->ServiceID) ? $row->ServiceID : NULL;
                                            $CategoryID = !empty($row->CategoryID) ? $row->CategoryID : NULL;
                                            $updateUrl = baseUrl('content_management/update_service_content.php?updateId=' . $ContentID . "&serviceID=$ServiceID&CategoryID=$CategoryID");
                                            $deleteUrl = baseUrl('content_management/delete_service_content.php?deleteId=' . $ContentID . "&serviceID=$ServiceID");
                                            $audio_path = !empty($row->audio_path) ? $row->audio_path : "";
                                            $SMSText = !empty($row->SMSText) ? $row->SMSText : "";
                                            $image_path = !empty($row->image_path) ? $row->image_path : "";
                                            $video_path = !empty($row->video_path) ? $row->video_path : "";
                                            $Status = !empty($row->Status) ? $row->Status : "";
                                            $ActivationDate = !empty($row->ActivationDate) ? $row->ActivationDate : "";
                                            $DeactivationDate = !empty($row->DeactivationDate) ? $row->DeactivationDate : "";

                                            $updated_by = !empty($row->updated_by) ? $row->updated_by : "";
                                            $updated_at = longDateHuman($row->LastUpdate, 'date_time');
                                            $createdBy = !empty($row->created_by) ? $row->created_by : "";
                                            $created = longDateHuman($row->createdAt, 'date_time');

                                            $updateUrl .= "&content_text=$SMSText&content_image=$image_path&content_audio=$audio_path&content_video=$video_path&content_status=$Status&content_activation_date=$ActivationDate";
                                            ?>
                                            <tr class="">
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <a href="<?php echo $updateUrl; ?>"><?php echo $ContentID; ?></a>
                                                </td>
                                                <td><?php echo $ServiceID; ?></td>
                                                <td><?php echo str_replace($ServiceID, '', $CategoryID);
                                                    ?>
                                                </td>
                                                <td><?php if ($image_path <> '') { ?><a
                                                        href="<?php echo $image_path; ?>" target="_blank"> <img
                                                                src=" <?php echo $image_path; ?> " width="50"
                                                                height="60"/>
                                                        </a>
                                                    <?php } else echo 'NA'; ?></td>
                                                <td> <?php if ($audio_path <> '') { ?>
                                                    <audio controls src="<?php echo $audio_path; ?>"
                                                           alt="No Audio"
                                                           width="150"
                                                           height="80"
                                                           style="max-width:95%;border:3px solid black;">
                                                            <code>audio</code>
                                                        </audio><?php } else echo 'NA'; ?>
                                                </td>
                                                <!-- <td><?php /*echo $video_path; */ ?></td>-->
                                                <td> <?php if ($video_path <> '') { ?>
                                                    <video controls src="<?php echo $video_path; ?>"
                                                           alt="no image"
                                                           width="150"
                                                           height="80"
                                                           style="max-width:95%;border:3px solid black;">
                                                        </video><?php } else echo 'NA'; ?>
                                                </td>
                                                <td><?php echo $SMSText; ?></td>
                                                <td><?php echo $Status; ?></td>
                                                <td><?php echo $ActivationDate; ?></td>
                                                <td><?php echo $DeactivationDate; ?></td>

                                                <td><?php echo $updated_by; ?></td>
                                                <td><?php echo $updated_at; ?></td>
                                                <td><?php echo $createdBy; ?></td>
                                                <td><?php echo $created; ?></td>

                                                <td class="">
                                                    <a class="btn btn-primary btn-xs" title="Update"
                                                       href="<?php echo $updateUrl; ?>"><i class="fa fa-edit"></i></a>
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

        function getService(sel) {

            var x = 0;
            x = sel.value;
            // alert(x);
            <?php  $uri = PROJECT_BASE_PATH . "/content_management/manage_service_content.php?serviceID=";?>
            window.location.replace('<?php echo $uri;?>' + x);
        }
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
        });
    </script>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>