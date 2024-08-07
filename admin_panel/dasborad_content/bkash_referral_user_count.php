<?php
$totalUser = json_decode(file_get_contents($bkashReferralTotalUrl));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $TotalFbUser = !empty($row->TotalFbUser) ? $row->TotalFbUser : 0;
            $MassReferrer = !empty($row->MassReferrer) ? $row->MassReferrer : 0;
            $RegisteredReferrer = !empty($row->RegisteredReferrer) ? $row->RegisteredReferrer : 0;
            $Ambassador = !empty($row->Genius) ? $row->Genius : 0;
            $Dut = !empty($row->Dut) ? $row->Dut : 0;
            $SelfRegistrationCount = !empty($row->SelfRegistrationCount) ? $row->SelfRegistrationCount : 0;
            $AppRegistrationCount = !empty($row->AppRegistrationCount) ? $row->AppRegistrationCount : 0;
        }
    } ?>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $TotalFbUser; ?></h1>
                <h6>Total FB User</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $MassReferrer; ?></h1>
                <h6>Mass Referrer</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $RegisteredReferrer; ?></h1>
                <h6>Registered Referrer</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $Ambassador; ?></h1>
                <h6>Genius</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $Dut; ?></h1>
                <h6>Dut</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $SelfRegistrationCount; ?></h1>
                <h6>Self Registration Count</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $AppRegistrationCount; ?></h1>
                <h6>App Registration Count</h6>
            </div>
        </section>
    </div>


</div>