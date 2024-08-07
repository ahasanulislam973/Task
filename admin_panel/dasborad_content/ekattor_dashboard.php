<?php
$ekattorDashboardReportURL = $baseUrl . "reporting/ekattorDashboardReport.php";
$totalUser = json_decode(file_get_contents($ekattorDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_hit = !empty($row->total_interaction) ? $row->total_interaction : 0;
            $ekattor_live = !empty($row->ekattor_live) ? $row->ekattor_live : 0;
            $ekattor_youtube = !empty($row->ekattor_youtube) ? $row->ekattor_youtube : 0;
            $online_vote = !empty($row->online_vote) ? $row->online_vote : 0;
            $quiz_contest = !empty($row->quiz_contest) ? $row->quiz_contest : 0;
            $certificate_course = !empty($row->certificate_course) ? $row->certificate_course : 0;

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
                <h6>Total Interaction</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $ekattor_live; ?></h1>
                <h6>Ekattor Live</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $ekattor_youtube; ?></h1>
                <h6>Ekattor Youtube </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $online_vote; ?></h1>
                <h6>Online Vote </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $quiz_contest; ?></h1>
                <h6>Quiz Contest </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $certificate_course; ?></h1>
                <h6>Certificate Course </h6>
            </div>
        </section>
    </div>


</div>