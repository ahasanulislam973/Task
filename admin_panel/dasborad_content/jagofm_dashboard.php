<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/jagofmDashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_interaction = !empty($row->total_interact) ? $row->total_interact : 0;
            $total_rj_adda = !empty($row->total_rj_adda) ? $row->total_rj_adda : 0;
            $total_quiz_time = !empty($row->total_quiz_time) ? $row->total_quiz_time : 0;
            $total_mashup_unlimited = !empty($row->total_mashup_unlimited) ? $row->total_mashup_unlimited : 0;
			$total_dance_master = !empty($row->total_dance_master) ? $row->total_dance_master : 0;
			$total_jago_podcast = !empty($row->total_jago_podcast) ? $row->total_jago_podcast : 0;
			$total_bbc_janala = !empty($row->total_bbc_janala) ? $row->total_bbc_janala : 0;
        }
    } ?>
 <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
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
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_interaction); ?></h1>
                <h6>Total Interactions</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_rj_adda); ?></h1>
                <h6>RJ আড্ডা!</h6>
            </div>
        </section>
    </div>
	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_quiz_time); ?></h1>
                <h6>কুইজ টাইম</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_mashup_unlimited); ?></h1>
                <h6>Mashup Unlimited</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_dance_master); ?></h1>
                <h6>Dance Master</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_jago_podcast); ?></h1>
                <h6>JAGO PODCAST</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_bbc_janala); ?></h1>
                <h6>BBC জানালা</h6>
            </div>
        </section>
    </div>

</div>