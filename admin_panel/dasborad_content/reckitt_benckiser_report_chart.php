<?php
$lineChartDataFb = json_decode(file_get_contents($bkashReferralFbBarChartDataUrl));
$lineChartData = json_decode(file_get_contents($bkashReferralMassLineChartDataUrl));
//print_r($lineChartData);exit;
?>
<div class="row">

    <div class="col-lg-5">
        <section class="panel">
            <div class="panel-body">
                <div id="fb_chart">
                </div>
                <link href="<?php echo baseUrl('assets/chart/styles.css'); ?>" rel="stylesheet"/>
                <script src="<?php echo baseUrl('assets/chart/apexChart.js'); ?>"></script>

                <?php
                $seriesData = array();
                $data = array();

                $data[] = (int)$lineChartDataFb[0]->Day1_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day2_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day3_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day4_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day5_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day6_FB_User;
                $data[] = (int)$lineChartDataFb[0]->Day7_FB_User;
                $seriesData[0]['data'] = $data;

                ?>

                <script>
                   data_series = <?php echo json_encode($seriesData); ?>;
                    var options = {
                        chart: {
                            type: 'bar',
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
                        series: data_series,
                        title: {
                            text: '7 days pledge trend',
                            align:
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
                            categories: ['Day1','Day2', 'Day3', 'Day4','Day5','Day6','Day7']


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
                        document.querySelector("#fb_chart"),
                        options
                    );
                   chart.render();

                </script>
            </div>

        </section>
    </div>

    <div class="col-lg-5">
        <section class="panel">
            <div class="panel-body">
                <div id="chart">
                </div>
                <link href="<?php echo baseUrl('assets/chart/styles.css'); ?>" rel="stylesheet"/>
                <script src="<?php echo baseUrl('assets/chart/apexChart.js'); ?>"></script>

                <?php
                $seriesData = array();
                $data = array();

                $data[] = (int)$lineChartData[0]->Day1_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day2_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day3_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day4_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day5_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day6_Mass_Referrer;
                $data[] = (int)$lineChartData[0]->Day7_Mass_Referrer;
                $seriesData[0]['data'] = $data;

                ?>

                <script>
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
                            text: 'Mass Referrer',
                            align:
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
                            categories: ['Day1','Day2', 'Day3', 'Day4','Day5','Day6','Day7']


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