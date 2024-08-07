<?php
$ReportingServiceName = json_decode(file_get_contents($reportingServiceNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']), true);
//print_r($ReportingServiceName);
$serviceTotalUser = json_decode(file_get_contents($serviceTotalUserUrl));
$totalCount = 0;
?>
<!--state overview start-->
<div class="row state-overview">
    <?php
    if (count($ReportingServiceName) > 1) {
        foreach ($ReportingServiceName as $key => $value) {
            if ($key == '0')
                continue;
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <section class="panel">
                    <div class="symbol <?php
                    $arrX = array("red", "blue", "yellow", "terques");
                    $randIndex = array_rand($arrX);
                    echo $arrX[$randIndex]; ?>">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="value">
                        <h1 class=" count4">
                            <?php

                            foreach ($serviceTotalUser

                            as $numService => $ServiceName) {
                            if ($ServiceName->ServiceID == $value){
                            echo $ServiceName->cnt;
                            $totalCount += $ServiceName->cnt;
                            ?>
                        </h1>
                        <h6><?php echo $value; ?></h6>
                        <?php }
                        } ?>
                    </div>
                </section>
            </div>
        <?php } ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="value">
                    <h1 class=" count4"><?php echo $totalCount; ?></h1>
                    <h6>Total Subscriber Base</h6>
                </div>
            </section>
        </div>
    <?php } ?>
</div>
<!--state overview end-->
