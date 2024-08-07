<?php
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

$pageTitle = "Add Admin User";
$tabActive = "admin_users";
$subTabActive = "add_admin_user";
$manageAdminUrl = baseUrl("admin_users/manage_admin_user.php");
$redirectUrl = baseUrl('admin_users/manage_admin_user.php');
include_once INCLUDE_DIR . 'header.php';

$organizationId = $_SESSION['admin_login_info']['organization_id'];
$adminRoles = getAdminRoles($organizationId);
$organizations = getOrganization();
$createdBy = $_SESSION['admin_login_info']['user_id']; // super admin userId from session
$emailVerificationCode = getRandomString(7);
$errorMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['save'])) {

        $userName = $_POST['username'];
        $userEmail = $_POST['email'];


        if (empty($_POST['fullname'])) {
            $errorMsg .= "<p>Full Name Required</p>";
        }
        /*elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST['fullname'])) {
            $errorMsg .= "Fullname only letters & white space allowed";
        }*/


        if (empty($userName)) {
            $errorMsg .= "<p>Username required</p>";
        }
        if (empty($userEmail)) {
            $errorMsg .= "<p>Email required</p>";
        } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format";
        }

        if (empty($_POST['role_id'])) {
            $errorMsg .= "<p>Admin role required</p>";
        }
        if (empty($_POST['organization_id'])) {
            $errorMsg .= "<p>User Organization required</p>";
        }

        if (empty($_POST['password'])) {
            $errorMsg .= "<p>Password required</p>";
        }

        if (empty($_POST['con_password'])) {
            $errorMsg .= "<p>Confirm password required</p>";
        }

        if ($_POST['con_password'] !== $_POST['password']) {
            $errorMsg .= "<p>Password not matched!</p>";
        }


        if (!empty($userName)) {
            if (isDataExists('admin_users', 'username', $userName)) {
                $errorMsg .= "<p>User NAME already exists. please choose a unique NAME.</p>";
            }
        }

        if (!empty($userEmail)) {
            if (isDataExists('admin_users', 'email', $userEmail)) {
                $errorMsg .= "<p>User EMAIL already exists. please choose a unique EMAIL.</p>";
            }
        }

        if (null == $errorMsg) {
            $data = array(
                'role_id' => cleanInput($_POST['role_id']),
                'organization_id' => cleanInput($_POST['organization_id']),
                'phone' => cleanInput($_POST['phone']),
                'fullname' => cleanInput($_POST['fullname']),
                'email' => cleanInput($_POST['email']),
                'username' => cleanInput($_POST['username']),
                'password' => md5(cleanInput($_POST['password'])),
                'password_plain' => cleanInput($_POST['password']),
                'lastlogin_ip' => trim($_SERVER['REMOTE_ADDR']),
                'created_by' => $createdBy,
                'verify_code' => $emailVerificationCode,
                'status' => 0, // not verified yet
                'created_at' => date('Y-m-d H:i:s'),
            );

            if (saveAdminUser($data)) {
                // $_SESSION['successMsg'] = 'Admin added successfully';
                $verifyArr = array('code' => $emailVerificationCode, 'verifyEmail' => 1);
                // $encrypted = base64_encode('code=' . $emailVerificationCode . '&verifyEmail=1');
                $encrypted = base64_encode(json_encode($verifyArr));
                $verifyUrl = baseUrl('user_verification/verify_code.php') . '?data=' . $encrypted;
                $userName = $_POST['fullname'];
                $resp = sendEmailVerificationMailToUser();

                if ($resp == 'SUCCESS') {
                    $_SESSION['successMsg'] = "User has been added successfully. A confirmation mail is send to <strong> $userEmail </strong> mail.";
                }
                $_SESSION['successMsg'] = "User has been added successfully.";

                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['errorMsg'] = 'Admin not create successfully. Something Went Wrong !!';
            }
        }
    }
}

function sendEmailVerificationMailToUser()
{
    global $userName, $userEmail, $emailVerificationCode, $verifyUrl;

    $senderName = "The Himalayan Times ChatBot Admin Panel";
    $senderEmail = "vasmarketing@monitor.ssd-tech.com";
    $subject = "Email verification required for $senderName";

    $htmlContent = "<p>Dear " . $userName . ",</p>";
    $htmlContent .= "<p>An administrator has add your email address to $senderName. You need to verify your email to authenticate your account. ";
//    $htmlContent .= "<p>Your Email Verification Code is : <strong>" . $emailVerificationCode . "</strong> <br>";
    $htmlContent .= "Please go to the Verification Link by clicking " . $verifyUrl . "</p>";
    $htmlContent .= "<br><br>";
    $htmlContent .= "Sincerely,<br>";
    $htmlContent .= "<strong>The Himalayan Times Team</strong>";
    // var_dump(sendEMail($userEmail, $subject, $htmlContent, $senderEmail, $senderName)); exit;

    $userEmail = array($userEmail);

    // sendMailWithAttachment($userEmail, $subject , $htmlContent, '', $senderEmail, $senderName);

    if (sendMailWithAttachment($userEmail, $subject , $htmlContent, '', $senderEmail, $senderName)) {
   // if (sendEMail($userEmail, $subject, $htmlContent, $senderEmail, $senderName)) {
        return 'SUCCESS';
    } else {
        return 'FAILED';
    }

}

?>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <link href="<?php echo baseUrl('assets/modules/bootstrap-fileupload/bootstrap-fileupload.css'); ?>"
                  rel="stylesheet"/>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $pageTitle; ?>
                            <span class="pull-right">
                              <a href="<?php echo $manageAdminUrl; ?>" class=" btn btn-success btn-xs"> Manage Users</a>
                          </span>
                        </header>

                        <div class="panel-body panel-primary">

                            <div class="row">

                                <div class="col-md-12">
                                    <?php if (isset($errorMsg) && null != $errorMsg) { ?>
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

                                </div>

                                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">

                                    <h4 class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_title">User
                                        Information </h4>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Full Name<span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="Full Name" name="fullname"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['fullname'] : ''; ?>">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>User Name<span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="User Name" name="username" class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['username'] : ''; ?>">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Email Address <span class="text-danger">*</span> </label>
                                        <input type="email" placeholder="Email Address" name="email"
                                               class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['email'] : ''; ?>">
                                    </div>

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
                                        <label for="role">Choose Role <span class="text-danger">*</span></label>
                                        <select name="role_id" class="form-control">
                                            <?php foreach ($adminRoles as $key => $val) { ?>
                                                <option value="<?php echo $key ?>"
                                                    <?php if (isset($_POST['save']) && $_POST['role_id'] == $key) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $val; ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Phone Number </label>
                                        <input type="tel" placeholder="Phone Number" name="phone" class="form-control"
                                               value="<?php echo (isset($_POST['save'])) ? $_POST['phone'] : ''; ?>">
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Password <span class="text-danger">*</span> </label>
                                                <input type="password" name="password" class="form-control"
                                                       placeholder="Password"
                                                       value="<?php echo (isset($_POST['save'])) ? $_POST['password'] : ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Confirm Password <span class="text-danger">*</span> </label>
                                                <input type="password" name="con_password" class="form-control"
                                                       placeholder="Confirm Password"
                                                       value="<?php echo (isset($_POST['save'])) ? $_POST['con_password'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                                    <div class="col-md-3">
                                        <button class="btn btn-warning btn-block btn-sm" type="submit" name="save"
                                                value="1">Save
                                        </button>
                                    </div>

                                </form><!-- Form -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>

<?php include_once INCLUDE_DIR . 'footer.php'; ?>