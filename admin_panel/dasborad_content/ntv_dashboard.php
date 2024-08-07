<?php
$totalUser = json_decode(file_get_contents($ntvDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_hit = !empty($row->total_hit) ? $row->total_hit : 0;
            $total_entertainment = !empty($row->total_entertainment) ? $row->total_entertainment : 0;
            $total_livetv = !empty($row->total_livetv) ? $row->total_livetv : 0;
            $total_news = !empty($row->total_news) ? $row->total_news : 0;
            $total_quiztime = !empty($row->total_quiztime) ? $row->total_quiztime : 0;
			$total_bbc = !empty($row->total_bbc) ? $row->total_bbc : 0;
            $total_gallery = !empty($row->total_gallery) ? $row->total_gallery : 0;
            $NTV_DOTQUIZ = !empty($row->NTV_DOTQUIZ) ? $row->NTV_DOTQUIZ : 0;
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
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_entertainment; ?></h1>
                <h6>Entertainment</h6>
            </div>
        </section>
    </div>
	    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_livetv; ?></h1>
                <h6>Live TV</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_news; ?></h1>
                <h6>News</h6>
            </div>
        </section>
    </div>
	 <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_quiztime; ?></h1>
                <h6>Quiz Time</h6>
            </div>
        </section>
    </div>
<div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_bbc; ?></h1>
                <h6>Bbc Janala</h6>
            </div>
        </section>
    </div>
	<div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_gallery; ?></h1>
                <h6>Chobir Gallery</h6>
            </div>
        </section>
    </div>
		<div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $NTV_DOTQUIZ; ?></h1>
                <h6>NTV DOT QUIZ</h6>
            </div>
        </section>
    </div>

</div>