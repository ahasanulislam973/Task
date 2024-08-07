<?php
$sohojDashboardReportURL = $baseUrl . "reporting/sohojDashboardReport.php";
$totalUser = json_decode(file_get_contents($sohojDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_hit = !empty($row->total_interaction) ? $row->total_interaction : 0;
            $sohoj_game_kheltechai = !empty($row->sohoj_game_kheltechai) ? $row->sohoj_game_kheltechai : 0;
            $adda_dite_chai = !empty($row->adda_dite_chai) ? $row->adda_dite_chai : 0;
            $sohoj_protidin = !empty($row->sohoj_protidin) ? $row->sohoj_protidin : 0;
            $sohoj_top_up = !empty($row->sohoj_top_up) ? $row->sohoj_top_up : 0;

        }
    } ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_unique_user; ?></h1>
                <h6>Total Unique User</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_hit; ?></h1>
                <h6>Total Interactions</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $sohoj_game_kheltechai; ?></h1>
                <h6>Sohoj Games</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $adda_dite_chai; ?></h1>
                <h6>Addabaji</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $sohoj_protidin; ?></h1>
                <h6>Sohoj Protidin</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $sohoj_top_up; ?></h1>
                <h6>Top-Up </h6>
            </div>
        </section>
    </div>

    


</div>