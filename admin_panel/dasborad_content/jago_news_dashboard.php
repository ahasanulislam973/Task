<?php

//Db config

$dbtype = "mysqli";
$Server = "192.168.241.126";
$UserID = "service_team";
$Password = "S3rV!c3@t3@m";
$Database = "jagonews24_bot";

// Db config

$cn = connectDB();

$qry = "SELECT COUNT(*) as user_uniq FROM `GetStarted`";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$total_unique_user = $row['user_uniq'];

$qry = "SELECT COUNT(*) total_hit FROM nodeLog";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$total_hit = $row['total_hit'];

// live update

$qry = "SELECT  COUNT(*) AS live_update FROM `nodeLog` WHERE `node_name` =  'করোনাঃ লাইভ আপডেট'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$liveUpdate = $row['live_update'];

// Corona Donation
$qry = "SELECT  COUNT(*) AS corona_don FROM `nodeLog` WHERE `node_name` = 'অনুদান দিন'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$coronaDonation = $row['corona_don'];

// Country News
$qry = "SELECT  COUNT(*) AS cntry_news FROM `nodeLog` WHERE `node_name` LIKE 'দেশের খবর%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$countryNews = $row['cntry_news'];

// International News

$qry = "SELECT  COUNT(*) AS int_news FROM `nodeLog` WHERE `node_name` LIKE 'আন্তর্জাতিক খবর%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$internationalNews = $row['int_news'];

//	Sports News
$qry = "SELECT  COUNT(*) AS sports FROM `nodeLog` WHERE `node_name` LIKE 'খেলার%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$SportsNews = $row['sports'];

//  Entertainment News
$qry = "SELECT  COUNT(*) AS enews FROM `nodeLog` WHERE `node_name` LIKE 'বিনোদন%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$entertainmentNews = $row['enews'];

//Feature News
$qry = "SELECT  COUNT(*) AS fe_news FROM `nodeLog` WHERE `node_name` LIKE 'ফিচার%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$featureNews = $row['fe_news'];

// BBC JANALA

$qry = "SELECT  COUNT(*) AS bbc FROM `nodeLog` WHERE `node_name` LIKE 'BBC জানালা%'";
$rs = Sql_exec($cn, $qry);
$row = Sql_fetch_assoc_array($rs);
$bbcJanala = $row['bbc'];


closedDBconnection($cn);
?>

<div class="row state-overview">


    <div class="col-lg-3 col-md-4 col-sm-6">
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

    <div class="col-lg-3 col-md-4 col-sm-6">
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

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($liveUpdate); ?></h1>
                <h6>Corona LIVE Update </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($coronaDonation); ?></h1>
                <h6>Corona Donation</h6>
            </div>
        </section>
    </div>


    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($countryNews); ?></h1>
                <h6>Country News</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($internationalNews );?></h1>
                <h6>International News</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($entertainmentNews);?></h1>
                <h6>Entertainment News</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($SportsNews); ?></h1>
                <h6>Sports News</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($featureNews); ?></h1>
                <h6>Feature News</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($bbcJanala); ?></h1>
                <h6>BBC JANALA</h6>
            </div>
        </section>
    </div>

</div>