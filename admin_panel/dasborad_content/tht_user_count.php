<?php
$totalUser = json_decode(file_get_contents($totalLogUrl));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $thisWeekTotal = !empty($row->thisWeekTotal) ? $row->thisWeekTotal : 0;
            $pastWeekTotal = !empty($row->pastWeekTotal) ? $row->pastWeekTotal : 0;
            $thisMonthTotal = !empty($row->thisMonthTotal) ? $row->thisMonthTotal : 0;
            $pastMonthTotal = !empty($row->pastMonthTotal) ? $row->pastMonthTotal : 0;
        }
    } ?>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $thisWeekTotal; ?></h1>
                <h6>Current Week's Users</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $pastWeekTotal; ?></h1>
                <h6>Last Week's Users</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $thisMonthTotal; ?></h1>
                <h6>Current Month's Users</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $pastMonthTotal; ?></h1>
                <h6>Last Month's Users</h6>
            </div>
        </section>
    </div>

</div>