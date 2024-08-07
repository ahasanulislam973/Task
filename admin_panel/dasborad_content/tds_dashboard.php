<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/tds_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $Total_Subscribers = !empty($row->Total_Subscribers) ? $row->Total_Subscribers : 0;
            $Quiz_Contest = !empty($row->Quiz_Contest) ? $row->Quiz_Contest : 0;
            $Bangladesh_CheckOutNow = !empty($row->Bangladesh_CheckOutNow) ? $row->Bangladesh_CheckOutNow : 0;
			$World_CheckOutNow = !empty($row->World_CheckOutNow) ? $row->World_CheckOutNow : 0;
			$TheDailyStartBangla_CheckOutNow= !empty($row->TheDailyStartBangla_CheckOutNow) ? $row->TheDailyStartBangla_CheckOutNow : 0;
			$Business_CheckOutNow = !empty($row->Business_CheckOutNow) ? $row->Business_CheckOutNow : 0;
			$Opinion_CheckOutNow= !empty($row->Opinion_CheckOutNow) ? $row->Opinion_CheckOutNow : 0;
            $Sports_CheckOutNow= !empty($row->Sports_CheckOutNow) ? $row->Sports_CheckOutNow : 0;
            $ArtsEntertainment_CheckOutNow = !empty($row->ArtsEntertainment_CheckOutNow) ? $row->ArtsEntertainment_CheckOutNow : 0;
            $Travel_CheckOutNow = !empty($row->Travel_CheckOutNow) ? $row->Travel_CheckOutNow : 0;
        }
    } ?>


 <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_unique_user); ?></h1>
                <h6>Total Unique Users</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Total_Interactions); ?></h1>
                <h6>Total Interactions</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Total_Subscribers); ?></h1>
                <h6>Total Subscriptions</h6>
            </div>
        </section>
    </div>

	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Quiz_Contest); ?></h1>
                <h6>Quiz Contest</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Bangladesh_CheckOutNow); ?></h1>
                <h6>Bangladesh</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($World_CheckOutNow); ?></h1>
                <h6>World</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($TheDailyStartBangla_CheckOutNow); ?></h1>
                <h6>The Daily Star Bangla</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Business_CheckOutNow); ?></h1>
                <h6>Business</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Opinion_CheckOutNow); ?></h1>
                <h6>Opinion</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Sports_CheckOutNow); ?></h1>
                <h6>Sports</h6>
            </div>
        </section>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ArtsEntertainment_CheckOutNow); ?></h1>
                <h6>Arts & Entertainment</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Travel_CheckOutNow); ?></h1>
                <h6>Travel</h6>
            </div>
        </section>
    </div>


</div>