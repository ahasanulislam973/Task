<?php
$totalUser = json_decode(file_get_contents($fffDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_subscription = !empty($row->total_subscription) ? $row->total_subscription : 0;
            $total_attend_tournament = !empty($row->total_attend_tournament) ? $row->total_attend_tournament : 0;
            $total_buy_diamond = !empty($row->total_buy_diamond) ? $row->total_buy_diamond : 0;
            $total_gameplay_stream = !empty($row->total_gameplay_stream) ? $row->total_gameplay_stream : 0;
			$join_community = !empty($row->join_community) ? $row->join_community : 0;
        }
    } ?>
 <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_unique_user; ?></h1>
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
                <h1 class=" count4"><?php echo $total_subscription; ?></h1>
                <h6>Total Subscription</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_attend_tournament; ?></h1>
                <h6>Tournament</h6>
            </div>
        </section>
    </div>
	    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_buy_diamond; ?></h1>
                <h6>Diamond Buy</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_gameplay_stream; ?></h1>
                <h6>Streaming</h6>
            </div>
        </section>
    </div>
	    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $join_community; ?></h1>
                <h6>Community</h6>
            </div>
        </section>
    </div>
	

</div>