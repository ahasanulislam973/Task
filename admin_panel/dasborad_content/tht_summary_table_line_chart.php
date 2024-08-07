<?php
$lineChartData = json_decode(file_get_contents($lineChartDataUrl));
$servicesUsedByUser = json_decode(file_get_contents($serviceUsedByUserLogUrl));
?>
<div class="row">

    <div class="col-lg-6">
        <table class="responstable">
            <tr>
                <th></th>
                <th colspan="2">Today</th>
                <th colspan="2">Yesterday</th>
            </tr>
            <tr>
                <th>Service Name</th>
                <th><span>User</span></th>
                <th>Hit Count</th>
                <th>User</th>
                <th>Hit Count</th>
            </tr>
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
                    <tr>
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
            <tr>
                <th colspan="5"><i class="fa fa-bar-chart-o"></i> Services Summary</th>
            </tr>
            </tbody>
        </table>
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
                        $seriesData[$i]['name'] = longDateHuman($todayDate, 'date');
                    else if ($i == 1)
                        $seriesData[$i]['name'] = longDateHuman($yesterdayDate, 'date');
                    else if ($i == 2)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDate, 'date');

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