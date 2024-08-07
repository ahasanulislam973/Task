<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/nokia_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $Total_Subscribers = !empty($row->Total_Subscribers) ? $row->Total_Subscribers : 0;
            $GetStarted_Bangla = !empty($row->GetStarted_Bangla) ? $row->GetStarted_Bangla : 0;
            $GetStarted_English = !empty($row->GetStarted_English) ? $row->GetStarted_English : 0;
			$NokiaMobileMenu = !empty($row->NokiaMobileMenu) ? $row->NokiaMobileMenu : 0;
			$BuyANokiaMobile_LetsGetShopping = !empty($row->BuyANokiaMobile_LetsGetShopping) ? $row->BuyANokiaMobile_LetsGetShopping : 0;
			$AndroidPhones_Choose = !empty($row->AndroidPhones_Choose) ? $row->AndroidPhones_Choose : 0;
			$ClassicPhones_Choose = !empty($row->ClassicPhones_Choose) ? $row->ClassicPhones_Choose : 0;
			$SupportCenter_NokiaPhoneStore = !empty($row->SupportCenter_NokiaPhoneStore) ? $row->SupportCenter_NokiaPhoneStore : 0;
			$NewOffers_NewOffers = !empty($row->NewOffers_NewOffers) ? $row->NewOffers_NewOffers : 0;
			$ContactAgent_ContactAgent = !empty($row->ContactAgent_ContactAgent) ? $row->ContactAgent_ContactAgent : 0;
        }
    } ?>

<div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Total_Subscribers); ?></h1>
                <h6>Total Subscribers</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Total_Interactions); ?></h1>
                <h6>Total Interactions</h6>
            </div>
        </section>
    </div>

 <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($total_unique_user); ?></h1>
                <h6>Total Unique Users</h6>
            </div>
        </section>
    </div>


	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($GetStarted_Bangla); ?></h1>
                <h6>Language Preference: Bangla </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($GetStarted_English); ?></h1>
                <h6>Language Preference: English</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($NokiaMobileMenu); ?></h1>
                <h6>Nokia Mobile Menu </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($BuyANokiaMobile_LetsGetShopping); ?></h1>
                <h6>Buy a Nokia Mobile </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($AndroidPhones_Choose); ?></h1>
                <h6>Android Phone</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ClassicPhones_Choose); ?></h1>
                <h6>Classic Phone</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($SupportCenter_NokiaPhoneStore); ?></h1>
                <h6>Support Center </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($NewOffers_NewOffers); ?></h1>
                <h6>New Offers</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ContactAgent_ContactAgent); ?></h1>
                <h6>Contact Agent</h6>
            </div>
        </section>
    </div>

</div>