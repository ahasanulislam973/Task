<?php
session_start();
require '../lib/functions.php';
require '../config/service_config.php';
require_once '../helpers/helpers.php';

if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}

/* $currentFileName = basename(__FILE__);
if (!hasPermission(strtolower($currentFileName))) {
    header('Location: ' . $accessDeniedPage);
    exit;
} */

$pageTitle = "Image Resize Module ";
include_once INCLUDE_DIR . 'header.php';

$adminId = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$errorMsg = null;

$_moduleImagePath = '/var/www/html/bot_service_panel/uploads/';
$_moduleResizedImagePath = '/var/www/html/bot_service_panel/uploads/resized/';
$_getImageSize = array(
    'original' => array('width' => 930, 'height' => 900, 'crop' => FALSE),
    'resized' => array('width' => 350, 'height' => 350, 'crop' => FALSE),
);

// image upload action
if (isset($_POST['submit'])) {

    $imageField = 'image';
    $fileUploadResp = fileUpload($_moduleImagePath, $imageField);

    if (false != $fileUploadResp['filename']) {

        // starting image upload and resize.
        $initPath = $_moduleImagePath . $fileUploadResp['filename']; // original
        $mainPath = $_moduleImagePath . 'original/' . $fileUploadResp['filename']; // main image path
        $resizedPath = $_moduleResizedImagePath . $fileUploadResp['filename']; // resized path

        // resizing the image
        imgageResize($initPath, $mainPath, $_getImageSize['original']); // main path image
        imgageResize($initPath, $resizedPath, $_getImageSize['resized']); // resize with thumbs

        if (file_exists($initPath)) {
            @unlink($initPath);
        }
        // end of image upload and resize.

    } else {
        echo $fileUploadResp['message'];
    }
}

function fileUpload($fileUploadPath, $imageField)
{
    $uploadOk = true;
    $warningMsg = "";
    $uploadedFileName = false;
    $fileSize = 500000;
    $originalFileLocation = $fileUploadPath . basename($_FILES[$imageField]["name"]);
    $temp = explode(".", $_FILES[$imageField]["name"]);
    $newFileLocation = $fileUploadPath . round(microtime(true)) . '.' . end($temp);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$imageField]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = true;
        $warningMsg = "File is an image - " . $check["mime"] . ".";
    } else {
        $uploadOk = false;
        $warningMsg = "File is not an image.";
    }

    /* // Check if file already exists
    if (file_exists($targetFile)) {
        $warningMsg = "Sorry, file already exists.";
        $uploadOk = false;
    } */

    // Check file size
    if ($_FILES[$imageField]["size"] > $fileSize) {
        $uploadOk = false;
        $warningMsg = "Sorry, your file is too large.";
    }

    $imageTypeArr = array("jpg", "png", "jpeg", "gif");
    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($originalFileLocation, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $imageTypeArr)) {
        $uploadOk = false;
        $warningMsg = "Sorry, only " . strtoupper(implode(',', $imageTypeArr)) . "files are allowed.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == false) {
        $warningMsg = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES[$imageField]["tmp_name"], $newFileLocation)) {
            $uploadedFileName = basename($newFileLocation);
            $warningMsg = "The file " . $uploadedFileName . " has been uploaded.";
        } else {
            $warningMsg = "Sorry, there was an error uploading your file.";
        }
    }

    $returnData = array(
        'success' => $uploadOk,
        'message' => $warningMsg,
        'filename' => $uploadedFileName,
    );

    return $returnData;
}

?>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                        </header>

                        <script type="text/javascript"
                                src="<?php echo baseUrl('assets/bootstrap-fileupload/bootstrap-fileupload.js'); ?>"></script>
                        <link rel="stylesheet" type="text/css"
                              href="<?php echo baseUrl('assets/bootstrap-fileupload/bootstrap-fileupload.css'); ?>"/>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-block alert-danger fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <strong>Error!</strong> <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <section class="panel">
                                    <header class="panel-heading">
                                        Add <?php //echo $this->_moduleName; ?>
                                        <span class="tools pull-right">
                                            <a class="btn btn-info" href="<?php // ?>"><span>Manage</span></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <form class="form-horizontal" role="form" action="" method="post"
                                              enctype="multipart/form-data">
                                            <!--<div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label">Image Name<span
                                                            class="req"> * </span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="image_name"
                                                           value="<?php /*// */ ?>"
                                                           placeholder="Image Name" class="form-control"/>
                                                </div>
                                            </div>-->

                                            <div class="form-group">
                                                <label class="control-label col-md-2">Choose Photo<span
                                                            class="req">*</span></label>

                                                <div class="col-md-10">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail"
                                                             style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                 alt=""/>
                                                        </div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail"
                                                             style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                        <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i
                                                    class="fa fa-paper-clip"></i> Select</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="image"/>
                                    </span>
                                                            <a href="#" class="btn btn-danger fileupload-exists"
                                                               data-dismiss="fileupload"><i class="fa fa-trash"></i>
                                                                Remove</a>
                                                        </div>
                                                        <br>
                                                        <span class="label label-danger">NOTE!</span><span> For best view please choose image w: 930px X h: 900px.</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-danger" name="submit"
                                                            value="1">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </section>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </section>
    </section>
<?php include_once INCLUDE_DIR . 'footer.php'; ?>