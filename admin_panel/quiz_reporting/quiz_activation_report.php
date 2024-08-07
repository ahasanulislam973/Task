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

$pageTitle = "Quiz Activation Report last 2 hours";
$tabActive = "quiz_reporting";
$subTabActive = "quiz_activation_report";
$contentPushHistory = json_decode(file_get_contents($contentPushHistoryUrl));
include_once INCLUDE_DIR . 'header.php';
?>
    <!--dynamic data table-->
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
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                    <thead>
                                    <tr class="">
                                        <th width="5%">SL</th>
                                        <th width="10%">Quiz Category</th>
                                        <th width="10%">Quiz ID</th>
                                        <th width="10%">Quiz Title</th>
                                        <th width="10%">Activation Count</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($contentPushHistory)) { ?>
                                        <?php
                                        foreach ($contentPushHistory as $key => $row) {

                                            $MSISDN = !empty($row->MSISDN) ? $row->MSISDN : "";
                                            $ServiceName = !empty($row->Service) ? $row->Service : "";
                                            $ContentId = !empty($row->Content_ID) ? $row->Content_ID : "";
                                            $sentTime = !empty($row->Sent_Time) ? $row->Sent_Time : "";
                                            $status = !empty($row->Status) ? $row->Status : "";
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $key + 1; ?></td>

                                                <td>
                                                    <?php echo "পাঁচমিশালী/বিবিধ"; ?>
                                                </td>
                                                <td>
                                                    <?php echo "NA"; ?>
                                                </td>

                                                <td>
                                                    <?php echo "সাধারণ জ্ঞান"; ?>
                                                </td>

                                                <td>
                                                    <?php echo "row data"; ?>
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

<?php include_once INCLUDE_DIR . 'footer.php'; ?>