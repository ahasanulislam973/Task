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

    $my_file = "1560861075.jpg";
    $my_path = "/var/www/html/bot_service_panel/uploads/resized/$my_file";
    $my_name = "Moon";
    $my_mail = "rhmoon21@gmail.com";
    $to_mail = "rhmoon21@gmail.com";
    $my_replyto = "my_reply_to@mail.net";
    $my_subject = "This is a mail with attachment.";
    $my_message = "Hallo, Moon you like this script? I hope it will help.";
    sendEMail($my_path, $to_mail, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
}


function sendEMail($attachment = false, $mailTo, $fromMail, $fromName, $replyTo, $subject, $message)
{
    $content = "";
    if (false != $attachment) {
        $file = $attachment;
        $fileSize = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $fileSize);
        fclose($handle);

        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $fileName = basename($file);
    }

    $eol = PHP_EOL;

    $header = "From: " . $fromName . " <" . $fromMail . ">\n";
    $header .= "Reply-To: " . $replyTo . "\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\n\n";

    $emessage = "--" . $uid . "\n";
    $emessage .= "Content-type:text/plain; charset=iso-8859-1\n";
    $emessage .= "Content-Transfer-Encoding: 7bit\n\n";
    $emessage .= $message . "\n\n";
    $emessage .= "--" . $uid . "\n";
    if (false != $attachment) {
        $emessage .= "Content-Type: application/octet-stream; name=\"" . $fileName . "\"\n"; // use different content types here
        $emessage .= "Content-Transfer-Encoding: base64\n";
        $emessage .= "Content-Disposition: attachment; filename=\"" . $fileName . "\"\n\n";
    }
    $emessage .= $content . "\n\n";
    $emessage .= "--" . $uid . "--";

    if (mail($mailTo, $subject, $emessage, $header)) {
        return "MAIL_SENT_SUCCESS";
    } else {
        return "MAIL_SENT_ERROR";
    }

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