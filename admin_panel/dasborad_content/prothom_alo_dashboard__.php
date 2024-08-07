<?php

//Db config
$Database = "prothom_alo";
// Db config

$cn = connectDB();

$qry = "SELECT COUNT(*) AS user_uniq FROM GetStarted";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$total_unique_user = $row['user_uniq'];

$qry = "SELECT COUNT(*) as total_hit FROM `nodeLog`";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$total_hit = $row['total_hit'];

$qry = "SELECT COUNT(*)  as live_update FROM `nodeLog` WHERE nodeName = 'Corona_Last_Update' OR nodeName = 'bangladesh_update' OR nodename = 'corona_poramorsho'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$coronaLIVEupdate = $row['live_update'];


$qry = "SELECT COUNT(*)  as corona_info FROM `nodeLog` WHERE nodeName = 'করোনা কি?' OR nodeName ='লক্ষণ ও উপসর্গ'  OR nodeName ='প্রতিরোধের উপায়' ";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$coronaInfo = $row['corona_info'];

$qry = "SELECT COUNT(*)  as mythsFacts  FROM `nodeLog` WHERE nodeName = 'ভুল ধারণা !' OR nodeName = 'কিভাবে ছড়ায়?' ";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$mythsFacts = $row['mythsFacts'];

$qry = "SELECT COUNT(*) as know_frist FROM `nodeLog` WHERE nodeName = 'ভ্রমণে সতর্কতা' OR nodeName ='কোয়ারেন্টাইন কি?'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$knowFirst = $row['know_frist'];

closedDBconnection($cn);

?>

<div class="row state-overview">

<!--    --><?php
/*      if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $total_hit = !empty($row->total_hit) ? $row->total_hit : 0;
            $coronaLIVEupdate = !empty($row->coronaLIVEupdate) ? $row->coronaLIVEupdate : 0;
            $knowFirst = !empty($row->knowFirst) ? $row->knowFirst : 0;
            $mythsFacts = !empty($row->mythsFacts) ? $row->mythsFacts : 0;
            $coronaInfo = !empty($row->coronaInfo) ? $row->coronaInfo : 0;
        }
    } */?>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_unique_user); ?></h1>
                <h6>Total Unique User</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_hit); ?></h1>
                <h6>Total User Interaction</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($coronaLIVEupdate); ?></h1>
                <h6>Corona LIVE Update </h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($coronaInfo) ?></h1>
                <h6>Corona Info</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($mythsFacts) ?></h1>
                <h6>Myths & Facts</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($knowFirst); ?></h1>
                <h6>know First</h6>
            </div>
        </section>
    </div>

</div>