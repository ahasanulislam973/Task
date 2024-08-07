<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/eCourier_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $Total_Unique_Users = !empty($row->Total_Unique_Users) ? $row->Total_Unique_Users : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $Merchant_Users = !empty($row->Merchant_Users) ? $row->Merchant_Users : 0;
            $Non_Merchant_Users = !empty($row->Non_Merchant_Users) ? $row->Non_Merchant_Users : 0;
            $Quick_Booking = !empty($row->Quick_Booking) ? $row->Quick_Booking : 0;
            $P2P_Delivery = !empty($row->P2P_Delivery) ? $row->P2P_Delivery : 0;
            $Courier_Support = !empty($row->Courier_Support) ? $row->Courier_Support : 0;
            $Parcel_Tracking = !empty($row->Parcel_Tracking) ? $row->Parcel_Tracking : 0;
            $eCourier_Services = !empty($row->eCourier_Services) ? $row->eCourier_Services : 0;
            $Coverage_Map = !empty($row->Coverage_Map) ? $row->Coverage_Map : 0;
            $FAQ = !empty($row->FAQ) ? $row->FAQ : 0;
            $Merchant_Hote_Chai = !empty($row->Merchant_Hote_Chai) ? $row->Merchant_Hote_Chai : 0;
        }
    } ?>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Total_Unique_Users); ?></h1>
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
                <h1 class=" count4"><?php echo number_format($Merchant_Users); ?></h1>
                <h6>Merchant Users</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Non_Merchant_Users); ?></h1>
                <h6>Non Merchant Users</h6>
            </div>
        </section>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Quick_Booking); ?></h1>
                <h6>Quick Booking</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($P2P_Delivery); ?></h1>
                <h6>P2P Delivery</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Courier_Support); ?></h1>
                <h6>Courier Support</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Parcel_Tracking); ?></h1>
                <h6>Parcel Tracking</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($eCourier_Services); ?></h1>
                <h6>eCourier Services</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Coverage_Map); ?></h1>
                <h6>Coverage Map</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($FAQ); ?></h1>
                <h6>FAQ</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Merchant_Hote_Chai); ?></h1>
                <h6>Merchant Hote Chai</h6>
            </div>
        </section>
    </div>



</div>