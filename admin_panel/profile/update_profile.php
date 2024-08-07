<?php
/**
 * Created by PhpStorm.
 * User: Raqib
 * Date: 1/30/2019
 * Time: 12:14 PM
 */

session_start();
require_once '../config/config.php';
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

$pageTitle = "Update User Profile";
$tabActive = "profile";
$subTabActive = "profile_update";
$manageAdminUrl = $redirectUrl = baseUrl("index.php");
include_once INCLUDE_DIR . 'header.php';

$userFullName = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['fullname'])) ? $_SESSION['admin_login_info']['fullname'] : "";
$userEmail = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['email'])) ? $_SESSION['admin_login_info']['email'] : "";
$userName = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['username'])) ? $_SESSION['admin_login_info']['username'] : "";
$userPhone = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['phone'])) ? $_SESSION['admin_login_info']['phone'] : "";
$userId = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['user_id'])) ? $_SESSION['admin_login_info']['user_id'] : "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errorMsg = null;

    if (isset($_POST['profileInfoSubmit'])) {

        $fullname = cleanInput(filter_input(INPUT_POST, 'fullname'));
        $phone = cleanInput(filter_input(INPUT_POST, 'phone'));

        if (empty($fullname)) {
            $errorMsg .= "<p>Full Name Required</p>";
        }

        if (null == $errorMsg) {

            $updateData = array(
                'fullname' => $fullname,
                'phone' => $phone
            );

            if (doUpdate('admin_users', $updateData, array('user_id' => $userId))) {

                $_SESSION['admin_login_info']['fullname'] = $fullname;
                $_SESSION['admin_login_info']['phone'] = $phone;
                $_SESSION['successMsg'] = 'Profile updated successfully.';
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Something went wrong !!';
            }
        }

    }

    if (isset($_POST['passwordSubmit'])) { // for password change request

        $oldPassword = cleanInput(filter_input(INPUT_POST, 'old_password'));
        $newPassword = cleanInput(filter_input(INPUT_POST, 'new_password'));
        $confirmNewPassword = cleanInput(filter_input(INPUT_POST, 'confirm_new_password'));

        if (empty($oldPassword)) {
            $errorMsg .= "<p>Old Password Required</p>";
        }

        if (empty($newPassword)) {
            $errorMsg .= "<p>New Password Required</p>";
        }

        if (empty($confirmNewPassword)) {
            $errorMsg .= "<p>Confirm New Password Required</p>";
        }

        if ($newPassword !== $confirmNewPassword) {
            $errorMsg .= "<p>Password not matched!</p>";
        }

        if (null == $errorMsg) {
            $inputedPassword = md5($oldPassword);
            $userInfoById = getUserInfo($userId);
            $existingPassword = $userInfoById->password;

            if ($existingPassword === $inputedPassword) {

                $updateData = array(
                    'password' => md5($newPassword)
                );

                if (doUpdate('admin_users', $updateData, array('user_id' => $userId))) {

                    $_SESSION['successMsg'] = 'Password updated successfully. Please login again!';
                    session_destroy(); // destroy all session data to re-login
                    $_SESSION['continue'] = $currentUrl;
                    header("Location: " . $loginUrl);
                    // header("Refresh:1; url=$loginUrl");

                    exit;
                } else {
                    $_SESSION['errorMsg'] = 'Something went wrong !!';
                }
            } else {
                $_SESSION['errorMsg'] = "Your given old password doesn't match with our system. Please try again.";
            }
        }

    }

}

?>

    <!-- page start-->
    <section id="main-content">
        <section class="wrapper site-min-height">

            <div class="row">
                <aside class="profile-nav col-lg-3">
                    <section class="panel">
                        <div class="user-heading round">
                            <a id="photo">
                                <?php $photoSrc = baseUrl('assets/img/avatar-mini.jpg'); ?>
                                <img src="<?php echo $photoSrc; ?>" alt="">
                            </a>
                            <h1><?php echo $userFullName; ?></h1>
                            <p><?php echo $userEmail; ?></p>
                        </div>
                    </section>
                </aside>
                <aside class="profile-info col-lg-9">

                    <?php if (isset($errorMsg) && null != $errorMsg) { ?>
                        <div class="alert alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Warning!</strong> <br>
                            <?php echo $errorMsg; ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_SESSION['errorMsg'])) { ?>
                        <div class="alert alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Error!</strong> <br>
                            <?php
                            echo $_SESSION['errorMsg'];
                            unset($_SESSION['errorMsg']);
                            ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_SESSION['successMsg'])) { ?>
                        <div class="alert alert-success fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>Success!</strong> <br>
                            <?php
                            echo $_SESSION['successMsg'];
                            unset($_SESSION['successMsg']);
                            ?>
                        </div>
                    <?php } ?>

                    <section class="panel">
                        <div class="bio-graph-heading">
                            Profile Modification
                        </div>
                        <div class="panel-body bio-graph-info">
                            <h1> Profile Info</h1>

                            <form class="form-horizontal" role="form" method="post" action="">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Full Name</label>

                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="fullname" name="fullname"
                                               placeholder=" " value="<?php echo $userFullName; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Username</label>

                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="username" placeholder=" "
                                               name="username" value="<?php echo $userName; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Email</label>

                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email" placeholder=" "
                                               value="<?php echo $userEmail; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Phone</label>

                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="mobile" placeholder=" " name="phone"
                                               value="<?php echo $userPhone; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-info" name="profileInfoSubmit" value="1">
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!--<section>
                        <div class="panel panel-primary">
                            <div class="panel-heading"> Change Avatar</div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post"
                                      action="">

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Change Avatar</label>

                                        <div class="col-lg-6">
                                            <input type="file" name="photo" class="file-pos" id="exampleInputFile"
                                                   onchange="readURL(this, 'photo')">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-info" name="avatarSubmit" value="1">
                                                Save
                                            </button>
                                            <button type="button" class="btn btn-default">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>-->

                    <section>
                        <div class="panel panel-primary">
                            <div class="panel-heading"> Set New Password</div>
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Current Password</label>

                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" id="c-pwd" name="old_password"
                                                   placeholder="Enter your current password"
                                                   autocomplete="off"
                                                   value="<?php echo (isset($_POST['passwordSubmit'])) ? $_POST['old_password'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">New Password</label>

                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" id="n-pwd" name="new_password"
                                                   placeholder="Enter your new password" autocomplete="off"
                                                   value="<?php echo (isset($_POST['passwordSubmit'])) ? $_POST['new_password'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Re-Type New Password</label>

                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" id="rt-pwd"
                                                   name="confirm_new_password"
                                                   placeholder="Retype new password" autocomplete="off"
                                                   value="<?php echo (isset($_POST['passwordSubmit'])) ? $_POST['confirm_new_password'] : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-info" name="passwordSubmit" value="1">
                                                Save
                                            </button>
                                            <button type="button" class="btn btn-default">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </section>
    </section>


<?php include_once INCLUDE_DIR . 'footer.php'; ?>