<?php
session_start();
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

$pageTitle = "Admin Index";
$tabActive = "dashboard";

$lineChartData = json_decode(file_get_contents($lineChartDataUrl));
$totalQuizUser = json_decode(file_get_contents($totalQuizUserUrl));
$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']), true);
//print_r($ReportingServiceName);
$serviceTotalUser = json_decode(file_get_contents($serviceTotalUserUrl));

$topScorer = json_decode(file_get_contents($topScorerUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
$ReportingCategoryName = json_decode(file_get_contents($quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']), true);
$catIdList = '';
foreach ($ReportingCategoryName as $catId => $catName) {
    $catIdList .= $catId . ",";
}
$catIdList = rtrim($catIdList, ',');

$quizActivation = json_decode(file_get_contents($quizActivationUrl . "?quiz_category_id=" . $catIdList));

$totalCount = 0;
include_once INCLUDE_DIR . 'header.php';


$servicesUsedByUser = json_decode(file_get_contents($serviceUsedByUserLogUrl));
$totalUser = json_decode(file_get_contents($totalLogUrl));

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

            <!--state overview start-->
            <div class="row state-overview">
                <?php
                if (count($ReportingServiceName) > 1) {
                    foreach ($ReportingServiceName as $key => $value) {
                        if ($key == '0
    <!--   -->
')
                            continue;
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <section class="panel">
                                <div class="symbol <?php
                                $arrX = array("red", "blue", "yellow", "terques");
                                $randIndex = array_rand($arrX);
                                echo $arrX[$randIndex]; ?>">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="value">
                                    <h1 class=" count4">
                                        <?php

                                        foreach ($serviceTotalUser

                                        as $numService => $ServiceName) {
                                        if ($ServiceName->ServiceID == $value){
                                        echo $ServiceName->cnt;
                                        $totalCount += $ServiceName->cnt;
                                        ?>
                                    </h1>
                                    <h6><?php echo $value; ?></h6>
                                    <?php }
                                    } ?>
                                </div>
                            </section>
                        </div>
                    <?php } ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <section class="panel">
                            <div class="symbol blue">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="value">
                                <h1 class=" count4"><?php echo $totalCount; ?></h1>
                                <h6>Total Subscriber Base</h6>
                            </div>
                        </section>
                    </div>
                <?php } ?>
            </div>
            <!--state overview end-->



            <div class="row">
                <div class="col-lg-5">
                    <!--user info table start-->
                    <section class="panel">


                        <div class="row state-overview">
                            <div class="col-lg-2 col-sm-4">
                                <section class="panel">
                                    <div class="symbol terques">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="value">
                                        <h1 class="count">495</h1>
                                        <p>New Users</p>
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <section class="panel">
                                    <div class="symbol red">
                                        <i class="fa fa-tags"></i>
                                    </div>
                                    <div class="value">
                                        <h1 class=" count2">947</h1>
                                        <p>Sales</p>
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <section class="panel">
                                    <div class="symbol yellow">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="value">
                                        <h1 class=" count3">328</h1>
                                        <p>New Order</p>
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                                <section class="panel">
                                    <div class="symbol blue">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="value">
                                        <h1 class=" count4">10328</h1>
                                        <p>Total Profit</p>
                                    </div>
                                </section>
                            </div>
                        </div>


                        <table class="table table-bordered">

                            <thead>
                            <tr class="">
                                <td class="bg-default text-dark text-center" colspan="4"><b>TOTAL</b>
                                </td>
                            </tr>
                            <tr class="">
                                <th class="table-success" width="20%">This Week</th>
                                <th class="table-primary" width="20%">Past Week</th>
                                <th class="table-danger" width="20%">This Month</th>
                                <th class="table-warning" width="20%">Past Month</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($totalUser)) { ?>
                                <?php
                                foreach ($totalUser as $key => $row) {
                                    $thisWeekTotal = !empty($row->thisWeekTotal) ? $row->thisWeekTotal : 0;
                                    $pastWeekTotal = !empty($row->pastWeekTotal) ? $row->pastWeekTotal : 0;
                                    $thisMonthTotal = !empty($row->thisMonthTotal) ? $row->thisMonthTotal : 0;
                                    $pastMonthTotal = !empty($row->pastMonthTotal) ? $row->pastMonthTotal : 0;
                                    ?>
                                    <tr class="">
                                        <td class="table-success"><?php echo $thisWeekTotal; ?></td>
                                        <td class="table-primary"><?php echo $pastWeekTotal; ?></td>
                                        <td class="table-danger"><?php echo $thisMonthTotal; ?></td>
                                        <td class="table-warning"><?php echo $pastMonthTotal; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>

                        </table>
                    </section>
                    <!--user info table end-->
                </div>

                <div class="col-lg-1">&nbsp</div>

                <div class="col-lg-6">
                    <!--user info table start-->
                    <section class="panel">
                        <div class="panel-body">
                            <img class="task-thumb" src="<?php echo $dashBoardQuizActivationImgUrl; ?>" alt=""
                                 width="90"
                                 height="83">

                            <div class="task-thumb-details">
                                <h1>Quiz Active Users</h1>
                                <p>Last 2 Hours</p>
                            </div>
                        </div>
                        <?php if (!empty($quizActivation)) { ?>
                            <table class="table table-hover personal-task">
                                <tbody>
                                <?php foreach ($quizActivation as $key => $row) { ?>
                                    <tr>
                                        <td>
                                            <i class=" fa fa-tasks"></i>
                                        </td>
                                        <td><?php echo $row->q_title ?></td>
                                        <td><?php echo $row->cnt ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </section>
                    <!--user info table end-->
                </div>
            </div>


            <!--service graphical representation start-->
            <div class="row">

                <div class="col-lg-6">
                    <section class="panel">
                        <table class="display table table-bordered">
                            <thead>
                            <tr class="">
                                <td class="text-dark text-center" colspan="5"><b>Service Used By User
                                        Report</b>
                                </td>
                            </tr>

                            <tr class="">
                                <td></td>
                                <td colspan="2"><b>TODAY</b></td>
                                <td colspan="2"><b>YESTERDAY</b></td>

                            </tr>
                            <tr class="">
                                <th width="20%">SERVICE</th>
                                <th width="20%">USERS</th>
                                <th width="20%">ServiceHitCount</th>
                                <th width="20%">USERS</th>
                                <th width="20%">ServiceHitCount</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($servicesUsedByUser)) { ?>
                                <?php
                                foreach ($servicesUsedByUser as $key => $row) {
                                    $Service = !empty($row->Service) ? $row->Service : "";
                                    $UsersToday = !empty($row->UsersToday) ? $row->UsersToday : 0;
                                    $ServiceHitCountToday = !empty($row->ServiceHitCountToday) ? $row->ServiceHitCountToday : 0;
                                    $UsersYesterday = !empty($row->UsersYesterday) ? $row->UsersYesterday : 0;
                                    $ServiceHitCountYesterday = !empty($row->ServiceHitCountYesterday) ? $row->ServiceHitCountYesterday : 0;

                                    ?>
                                    <tr class="gradeX">
                                        <td>
                                            <?php echo $Service; ?>
                                        </td>

                                        <td>
                                            <?php echo $UsersToday; ?>
                                        </td>
                                        <td>

                                            <?php echo $ServiceHitCountToday; ?>
                                        </td>
                                        <td>
                                            <?php echo $UsersYesterday; ?>
                                        </td>
                                        <td>

                                            <?php echo $ServiceHitCountYesterday; ?>
                                        </td>

                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </section>
                </div>

                <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body">
                            <div id="chart">
                            </div>
                            <link href="<?php echo baseUrl('assets/chart/styles.css'); ?>" rel="stylesheet"/>
                            <script src="<?php echo baseUrl('assets/chart/apexChart.js'); ?>"></script>

                            <?php
                            $seriesData = array();
                            $serviceName = array();

                            foreach ($lineChartData as $data) {
                                $serviceName[] = $data->Service;
                            }
                            $serviceName[] = 'Total User';

                            for ($i = 0; $i <= 2; $i++) {
                                if ($i == 0)
                                    $seriesData[$i]['name'] = $todayDate;
                                else if ($i == 1)
                                    $seriesData[$i]['name'] = $yesterdayDate;
                                else if ($i == 2)
                                    $seriesData[$i]['name'] = $b4YesterdayDate;

                                $data = array();
                                for ($j = 0; $j < count($lineChartData); $j++) {
                                    if ($i == 0) {
                                        $data[] = (int)$lineChartData[$j]->UsersToday;

                                    } else if ($i == 1) {
                                        $data[] = (int)$lineChartData[$j]->UsersYesterday;

                                    } else if ($i == 2) {
                                        $data[] = (int)$lineChartData[$j]->UsersB4Yesterday;

                                    }

                                }
                                $data[] = array_sum($data);
                                $seriesData[$i]['data'] = $data;
                            }
                            // echo json_encode($seriesData);

                            ?>

                            <script>
                                serviceName = <?php echo json_encode($serviceName); ?>;
                                data_series = <?php echo json_encode($seriesData); ?>;
                                var options = {
                                    chart: {
                                        type: 'line',
                                        shadow: {
                                            enabled: true,
                                            color: '#848E93',
                                            blur: 10,
                                            opacity: 1
                                        },
                                        toolbar: {
                                            show: false
                                        }
                                    },
                                    colors: ['#77B6EA', '#FE0000', '#005dff'],
                                    dataLabels: {
                                        enabled: true,
                                    },
                                    stroke: {
                                        curve: 'smooth'
                                    },
                                    series: data_series
                                    /*[{
                                         name: "28-07-2019",
                                         data: [28, 29, 33, 36, 32]
                                     },
                                         {
                                             name: "27-07-2019",
                                             data: [5, 11, 13, 18, 7]
                                         },
                                         {
                                             name: "26-07-2019",
                                             data: [12, 11, 90, 18, 17]
                                         }
                                     ]*/,
                                    title: {
                                        text: 'Service Graphical Representation(Last 3 days)',
                                        align:
                                            'left'
                                    }
                                    ,
                                    grid: {
                                        borderColor: '#e7e7e7',
                                        row:
                                            {
                                                colors: ['#E2E29E', 'transparent'], // takes an array which will be repeated on columns
                                                opacity:
                                                    0.5
                                            }
                                        ,
                                    }
                                    ,
                                    markers: {
                                        size: 6
                                    }
                                    ,
                                    xaxis: {
                                        categories: serviceName/*['THT Polls', 'Play To Win', 'THT Epaper', 'THT Subscription', 'Total Users']*/,

                                    }
                                    ,
                                    yaxis: {
                                        title: {
                                            text: 'Count'
                                        }
                                    }
                                    ,
                                    legend: {
                                        position: 'top',
                                        horizontalAlign: 'center',
                                        floating: true
                                    }
                                }
                                console.log(options);

                                var chart = new ApexCharts(
                                    document.querySelector("#chart"),
                                    options
                                );
                                chart.render();

                            </script>
                        </div>

                    </section>
                </div>

            </div>
            <!--service graphical representation end-->


            <!--top 5 scorer start-->
            <div class="row">

                <div class="col-lg-12">
                    <!--work progress start-->
                    <section class="panel">
                        <div class="panel-body">
                            <img class="task-thumb" src="<?php echo $dashBoardQuizTopScorerImgUrl; ?>" alt="" width="90"
                                 height="83">
                            <div class="task-thumb-details">
                                <h1>Top 5 Quiz Scorer</h1>
                                <p>Last 2 Hours</p>
                            </div>
                        </div>
                        <?php if (!empty($topScorer)) { ?>
                            <table class="display table table-bordered dataTable" id="my_dynamic_table">

                                <thead>
                                <tr class="">
                                    <th width="5%"><span class="badge bg-info">SL</span></th>
                                    <th width="10%"><span class="badge bg-info">Quiz Category</span></th>
                                    <th width="10%"><span class="badge bg-info">Quiz Title</span></th>
                                    <th width="10%"><span class="badge bg-info">MSISDN</span></th>
                                    <th width="10%"><span class="badge bg-info">Start Time</span></th>
                                    <th width="10%"><span class="badge bg-info">End Time</span></th>
                                    <th width="10%"><span class="badge bg-info">Duration</span></th>
                                    <th width="10%"><span class="badge bg-info">Score</span></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                foreach ($topScorer as $key => $row) {

                                    $quizCategoryName = !empty($row->quiz_category_name) ? $row->quiz_category_name : "";
                                    $quizTitle = !empty($row->quiz_title) ? $row->quiz_title : "";
                                    $MSISDN = !empty($row->msisdn) ? $row->msisdn : "";
                                    $startTime = !empty($row->start_time) ? $row->start_time : "";
                                    $endTime = !empty($row->end_time) ? $row->end_time : "";
                                    $duration = !empty($row->duration) ? $row->duration : "";
                                    $score = !empty($row->Score) ? $row->Score : "";
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $key + 1; ?></td>

                                        <td>
                                            <?php echo $quizCategoryName; ?>
                                        </td>
                                        <td>
                                            <?php echo $quizTitle; ?>
                                        </td>

                                        <td>
                                            <?php echo $MSISDN; ?>
                                        </td>

                                        <td>
                                            <?php echo $startTime; ?>
                                        </td>

                                        <td>
                                            <?php echo $endTime; ?>
                                        </td>
                                        <td>
                                            <?php echo $duration; ?>
                                        </td>
                                        <td>
                                            <?php echo $score; ?>
                                        </td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        <?php } ?>
                    </section>
                    <!--work progress end-->
                </div>
            </div>
            <!--top 5 scorer end-->

        </section>
    </section>
    <!--main content end-->

<?php include_once INCLUDE_DIR . 'footer.php'; ?>