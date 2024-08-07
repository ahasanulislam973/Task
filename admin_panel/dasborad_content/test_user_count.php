<?php
$totalUser = json_decode(file_get_contents($bkashReferralTotalUrl));
if (!empty($totalUser)) {
    foreach ($totalUser as $key => $row) {
        $TotalFbUser = !empty($row->TotalFbUser) ? $row->TotalFbUser : 0;
        $MassReferrer = !empty($row->MassReferrer) ? $row->MassReferrer : 0;
        $RegisteredReferrer = !empty($row->RegisteredReferrer) ? $row->RegisteredReferrer : 0;
        $Ambassador = !empty($row->Genius) ? $row->Genius : 0;
        $Dut = !empty($row->Dut) ? $row->Dut : 0;
        $SelfRegistrationCount = !empty($row->SelfRegistrationCount) ? $row->SelfRegistrationCount : 0;
        $AppRegistrationCount = !empty($row->AppRegistrationCount) ? $row->AppRegistrationCount : 0;

        $SelfRegistrationMassCount = !empty($row->SelfRegistrationMassCount) ? $row->SelfRegistrationMassCount : 0;
        $SelfRegistrationGeniusCount = !empty($row->SelfRegistrationGeniusCount) ? $row->SelfRegistrationGeniusCount : 0;
        $SelfRegistrationDutCount = !empty($row->SelfRegistrationDutCount) ? $row->SelfRegistrationDutCount : 0;

        $AppRegistrationMassCount = !empty($row->AppRegistrationMassCount) ? $row->AppRegistrationMassCount : 0;
        $AppRegistrationGeniusCount = !empty($row->AppRegistrationGeniusCount) ? $row->AppRegistrationGeniusCount : 0;
        $AppRegistrationDutCount = !empty($row->AppRegistrationDutCount) ? $row->AppRegistrationDutCount : 0;
    }

    ?>
    <div class="row state-overview">
        <div class="col-md-3">
            <div class="value">
                <h1 class=" count4"><?php echo number_format($TotalFbUser,0); ?></h1>
                <h6>Pressed "Get Started"</h6>
            </div>
        </div>

        <div class="col-md-3">
            <div class="value">
                <h1 class=" count4"><?php echo number_format($MassReferrer,0); ?></h1>
                <h6>Referral Link Generated(Mass)</h6>
            </div>
        </div>

        <div class="col-md-3">
            <div class="value">
                <h1 class=" count4"><?php echo number_format($RegisteredReferrer,0); ?></h1>
                <h6>Registered Referrer(Mass)</h6>
            </div>
        </div>

        <div class="col-md-3">
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Ambassador,0); ?></h1>
                <h6>Genius</h6>
            </div>
        </div>

        <div class="col-md-3">
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Dut,0); ?></h1>
                <h6>Dut</h6>
            </div>
        </div>
    </div>

    <div class="state-overview registration-count">
        <div class="row">
            <div class="col-md-6">
                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6">
                            <h1><?php echo number_format($SelfRegistrationCount,0); ?></h1>
                            <h6>Self Registration Count</h6>
                        </div>
                        <div class="col-md-6">
                            <h1><?php echo number_format($SelfRegistrationMassCount, 0); ?></h1>
                            <h6>Mass</h6>
                            <h1><?php echo  number_format($SelfRegistrationGeniusCount, 0); ?></h1>
                            <h6>Genius</h6>
                            <h1><?php echo  number_format($SelfRegistrationDutCount, 0); ?></h1>
                            <h6>Dut</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6">
                            <h1><?php echo number_format($AppRegistrationCount,0); ?></h1>
                            <h6>App Registration Count</h6>
                        </div>
                        <div class="col-md-6">
                            <h1><?php echo number_format($AppRegistrationMassCount, 0); ?></h1>
                            <h6>Mass</h6>
                            <h1><?php echo  number_format($AppRegistrationGeniusCount, 0); ?></h1>
                            <h6>Genius</h6>
                            <h1><?php echo  number_format($AppRegistrationDutCount, 0); ?></h1>
                            <h6>Dut</h6>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        </div>

    </div>
<?php } ?>