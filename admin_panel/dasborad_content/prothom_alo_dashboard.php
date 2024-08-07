<?php
$totalUser = json_decode(file_get_contents($prothomAloDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_hit = !empty($row->total_hit) ? $row->total_hit : 0;
            $headline = !empty($row->headline) ? $row->headline : 0;
            $bangladesh = !empty($row->bangladesh) ? $row->bangladesh : 0;
            $politics = !empty($row->politics) ? $row->politics : 0;
            $trade = !empty($row->trade) ? $row->trade : 0;
            $onnanya = !empty($row->onnanya) ? $row->onnanya : 0;
            $opinion = !empty($row->opinion) ? $row->opinion : 0;
            $job = !empty($row->job) ? $row->job : 0;
            $lifestyle = !empty($row->lifestyle) ? $row->lifestyle : 0;
            $epaper = !empty($row->epaper) ? $row->epaper : 0;
            $entertainment = !empty($row->entertainment) ? $row->entertainment : 0;
            $world = !empty($row->world) ? $row->world : 0;
            $epaper = !empty($row->epaper) ? $row->epaper : 0;
            $game = !empty($row->game) ? $row->game : 0;
            $online_vote = !empty($row->online_vote) ? $row->online_vote : 0;
            $live_update = !empty($row->live_update) ? $row->live_update : 0;
            $corona_info = !empty($row->corona_info) ? $row->corona_info : 0;
            $myth_fact = !empty($row->myth_fact) ? $row->myth_fact : 0;
            $know_first = !empty($row->know_first) ? $row->know_first : 0;
            $onnanya = !empty($row->onnanya) ? $row->onnanya : 0;
            $Uniquevote = !empty($row->Uniquevote) ? $row->Uniquevote : 0;
        }
    } ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
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
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $total_hit; ?></h1>
                <h6>Total User Interaction</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $live_update; ?></h1>
                <h6>Corona LIVE Update</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $corona_info; ?></h1>
                <h6>Corona Info</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $myth_fact; ?></h1>
                <h6>Myths & Facts</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $know_first; ?></h1>
                <h6>Know First</h6>
            </div>
        </section>
    </div>


    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $headline; ?></h1>
                <h6>Bishesh Songbad</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $bangladesh; ?></h1>
                <h6>Bangladesh</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $onnanya; ?></h1>
                <h6>Onnanya</h6>
            </div>
        </section>
    </div>



    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $politics; ?></h1>
                <h6>Rajneeti</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $trade; ?></h1>
                <h6>Banijjyo</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $opinion; ?></h1>
                <h6>Motamot</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $job; ?></h1>
                <h6>Chakri</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $lifestyle; ?></h1>
                <h6>Lifestyle</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $epaper; ?></h1>
                <h6>ePaper</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $entertainment; ?></h1>
                <h6>Binodon</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $world; ?></h1>
                <h6>Bisshyo</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $game; ?></h1>
                <h6>Khela</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $online_vote; ?></h1>
                <h6>Online Vote</h6>
            </div>
        </section>
    </div>
	<div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $Uniquevote ; ?></h1>
                <h6>H For Handwash - Unique vote count</h6>
            </div>
        </section>
    </div>

</div>