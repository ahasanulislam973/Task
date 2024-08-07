<?php
$totalUser = json_decode(file_get_contents($reckittDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_user = !empty($row->total_user) ? $row->total_user : 0;
            $TotalPledge = !empty($row->total_pledge) ? $row->total_pledge : 0;
            $total_unique_pledge = !empty($row->total_unique_pledge) ? $row->total_unique_pledge : 0;
            $todays_pladge = !empty($row->todays_pledge) ? $row->todays_pledge : 0;
            $todays_unique_pledge = !empty($row->todays_unique_pledge) ? $row->todays_unique_pledge : 0;
        }
    } ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_user; ?></h1>
                <h6>Total User</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $TotalPledge; ?></h1>
                <h6>Total Pledge</h6>
            </div>
        </section>
    </div>
<!--    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php /*echo $total_unique_pledge; */?></h1>
                <h6>Total Unique Pledge</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php /*echo $todays_pladge; */?></h1>
                <h6>Today's Pledge</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php /*echo $todays_unique_pledge; */?></h1>
                <h6>Today's Unique Pledge</h6>
            </div>
        </section>
    </div>-->


</div>