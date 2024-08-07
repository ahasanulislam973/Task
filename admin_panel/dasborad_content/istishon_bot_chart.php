<?php
//$lineChartData = json_decode(file_get_contents($lineChartDataUrl));
$lineChartData = json_decode(file_get_contents($istishonBotCategoryChartDataUrl));

?>
<div class="row">

    <div class="col-lg-12">
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
                    $serviceName[] = $data->serviceid;
                }
                $serviceName[] = 'Total User';

                for ($i = 0; $i <= 6; $i++) {
			//	for ($i = 6; $i >= 0 ; $i--) {  
					if ($i == 0)
                        $seriesData[$i]['name'] = longDateHuman($todayDate, 'date');
                    else if ($i == 1)
                        $seriesData[$i]['name'] = longDateHuman($yesterdayDate, 'date');
                    else if ($i == 2)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDate, 'date');
                    else if ($i == 3)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDateMinusOne, 'date');
                    else if ($i == 4)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDateMinusTwo, 'date');
                    else if ($i == 5)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDateMinusThree, 'date');
                    else if ($i == 6)
                        $seriesData[$i]['name'] = longDateHuman($b4YesterdayDateMinusFour, 'date');

                    $data = array();
                    for ($j = 0; $j < count($lineChartData); $j++) {
                        if ($i == 0) {
                            $data[] = (int)$lineChartData[$j]->UsersToday;

                        } else if ($i == 1) {
                            $data[] = (int)$lineChartData[$j]->UsersYesterday;

                        } else if ($i == 2) {
                            $data[] = (int)$lineChartData[$j]->UsersB4Yesterday;

                        }else if ($i == 3) {
                            $data[] = (int)$lineChartData[$j]->UsersB4YesterdayMinusOne;

                        } else if ($i == 4) {
                            $data[] = (int)$lineChartData[$j]->UsersB4YesterdayMinusTwo;

                        }else if ($i == 5) {
                            $data[] = (int)$lineChartData[$j]->UsersB4YesterdayMinusThree;

                        } else if ($i == 6) {
                            $data[] = (int)$lineChartData[$j]->UsersB4YesterdayMinusFour;

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
                    //alert(serviceName);
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
                            // text: 'Category Registration Base(Last 7 days)',
							text: 'This Week Service Health',
                            align:
                               // 'left'
							    'center'
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
                                // text: 'Count'
								text: 'Subscriber Count'
                            }
                        }
                        ,
                        legend: {
                            position: 'top',
							// position: 'bottom',
                            horizontalAlign: 'center',
                            floating: true
                        }
                    }
                    //console.log(options);

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