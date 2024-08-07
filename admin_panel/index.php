<?php

echo "Hello";
require_once './config/config.php';
require_once './config/service_config.php';

if (!checkAuthenticLogin()) {
    $_SESSION['continue'] = $currentUrl;
    header('Location: ' . $loginUrl);
    exit;
}
date_default_timezone_set("Asia/Dhaka");
$todayDate = date("Y-m-d", time());
$yesterdayDate = date('Y-m-d', strtotime($todayDate . ' - 1 days'));
$b4YesterdayDate = date('Y-m-d', strtotime($todayDate . ' - 2 days'));
$b4YesterdayDateMinusOne = date('Y-m-d', strtotime($todayDate . ' - 3 days'));
$b4YesterdayDateMinusTwo = date('Y-m-d', strtotime($todayDate . ' - 4 days'));
$b4YesterdayDateMinusThree = date('Y-m-d', strtotime($todayDate . ' - 5 days'));
$b4YesterdayDateMinusFour = date('Y-m-d', strtotime($todayDate . ' - 6 days'));

$pageTitle = "Admin Index";
$tabActive = "dashboard";

$organizationId = $_SESSION['admin_login_info']['organization_id'];

include_once INCLUDE_DIR . 'header.php';


?>

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['successMsg'])) { ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <br>
                        <?php
                        echo $_SESSION['successMsg'];
                        unset($_SESSION['successMsg']);
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>


        <?php
        switch ($organizationId) {
            case 0:
                include 'dasborad_content/regular_content_push_service_count.php';
                include 'dasborad_content/tht_user_count.php';

                /*service graphical representation start*/
                include 'dasborad_content/tht_summary_table_line_chart.php';
                /*service graphical representation end*/

                /*last 2 hours active user & top 5 scorer start*/
                include 'dasborad_content/quiz_2hours_tables.php';
                /*last 2 hours active user & top 5 scorer end */
                break;

            case 1:
            case 2:
                include 'dasborad_content/regular_content_push_service_count.php';

                /*last 2 hours active user & top 5 scorer start*/
                include 'dasborad_content/quiz_2hours_tables.php';
                /*last 2 hours active user & top 5 scorer end */
                break;

            case 3:
                echo '<h1>   সব বন্ধ! সব বন্ধ! সব বন্ধ করে দিসি ..............</h1>';
                break;

            case 4:
                include 'dasborad_content/tht_user_count.php';

                /*service graphical representation start*/
                include 'dasborad_content/tht_summary_table_line_chart.php';
                /*service graphical representation end*/

                /*last 2 hours active user & top 5 scorer start*/
                include 'dasborad_content/quiz_2hours_tables.php';
                /*last 2 hours active user & top 5 scorer end */
                break;

            case 5:
                echo '<h1>Dashboard of Istishon BOT</h1>';
                include 'dasborad_content/Istishon_bot_user_count.php';
                include 'dasborad_content/istishon_bot_chart.php';

                break;
            case 15:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/ntv_dashboard.php';
                break;
            case 16:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/prothom_alo_dashboard.php';
                break;
            case 17:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/jago_news_dashboard.php';
                break;
            case 18:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/fff_dashboard.php';
                break;
            case 19:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/jagofm_dashboard.php';
                break;
            case 20:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/tds_dashboard.php';
                break;
            case 21:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/ds_dashboard.php';
                break;
            case 22:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/nokia_dashboard.php';
                break;
            case 23:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/ekattor_dashboard.php';
                break;
            case 24:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/ghoori_dashboard.php';
                break;
            case 25:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/audra_dashboard.php';
                break;
            case 26:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/eCourier_dashboard.php';
                break;
            case 11:
                echo '<h1>  Dashboard </h1>';
                include 'dasborad_content/sohoj_dashboard.php';
                break;
        }

        ?>


    </section>
</section>
<!--main content end-->

<?php include_once INCLUDE_DIR . 'footer.php'; ?>