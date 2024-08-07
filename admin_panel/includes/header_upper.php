<?php
$userName = (isset($_SESSION['admin_login_info']) && !empty($_SESSION['admin_login_info']['fullname'])) ? $_SESSION['admin_login_info']['fullname'] : "";
?>

<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <i class="fa fa-bars"></i>
    </div>
    <!--logo start-->
    <a href="<?php echo baseUrl(); ?>" class="logo" style="margin-top: 0px">
        <img style="height: 80%; margin-top: 4px; width: 75%;" data-retina=""
             src="<?php echo baseUrl('assets/img/logo.png'); ?>"
             alt="Logo"></a>
    <!--logo end-->

    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!--<li>
                <input type="text" class="form-control search" placeholder="Search">
            </li>-->
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="<?php echo $userName; ?>" src="<?php echo baseUrl('assets/img/avatar-mini.jpg'); ?>">
                    <span class="username"><?php echo $userName; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li>
                        <a href="<?php echo baseUrl('profile/update_profile.php'); ?>"><i
                                    class="fa fa-user"></i>Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                    <li><a href="<?php echo $logoutUrl; ?>"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>