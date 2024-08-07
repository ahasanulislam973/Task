<?php
$totalUser = json_decode(file_get_contents($istishonBotTotalUrl));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $DailyNewsTotalUser = !empty($row->DailyNewsTotalUser) ? $row->DailyNewsTotalUser : 0;
			$DailyNewsActiveUser = !empty($row->DailyNewsActiveUser) ? $row->DailyNewsActiveUser : 0;
			$DailyNewsDeActiveUser = !empty($row->DailyNewsDeActiveUser) ? $row->DailyNewsDeActiveUser : 0;
			
            $HoroscopeTotalUser = !empty($row->HoroscopeTotalUser) ? $row->HoroscopeTotalUser : 0;
			$HoroscopeActiveUser = !empty($row->HoroscopeActiveUser) ? $row->HoroscopeActiveUser : 0;
			$HoroscopeDeActiveUser = !empty($row->HoroscopeDeActiveUser) ? $row->HoroscopeDeActiveUser : 0;
			
            $WordOfTheDayTotalUser = !empty($row->WordOfTheDayTotalUser) ? $row->WordOfTheDayTotalUser : 0;
            $WordOfTheDayActiveUser = !empty($row->WordOfTheDayActiveUser) ? $row->WordOfTheDayActiveUser : 0;
            $WordOfTheDayDeActiveUser = !empty($row->WordOfTheDayDeActiveUser) ? $row->WordOfTheDayDeActiveUser : 0;

            $LoveQuotesTotalUser = !empty($row->LoveQuotesTotalUser) ? $row->LoveQuotesTotalUser : 0;
            $LoveQuotesActiveUser = !empty($row->LoveQuotesActiveUser) ? $row->LoveQuotesActiveUser : 0;
            $LoveQuotesDeActiveUser = !empty($row->LoveQuotesDeActiveUser) ? $row->LoveQuotesDeActiveUser : 0;


            $TazaKhoborTotalUser = !empty($row->TazaKhoborTotalUser) ? $row->TazaKhoborTotalUser : 0;
            $TazaKhoborActiveUser = !empty($row->TazaKhoborActiveUser) ? $row->TazaKhoborActiveUser : 0;
            $TazaKhoborDeActiveUser = !empty($row->TazaKhoborDeActiveUser) ? $row->TazaKhoborDeActiveUser : 0;


            $RelationshipTipsTotalUser = !empty($row->RelationshipTipsTotalUser) ? $row->RelationshipTipsTotalUser : 0;
            $RelationshipTipsActiveUser = !empty($row->RelationshipTipsActiveUser) ? $row->RelationshipTipsActiveUser : 0;
            $RelationshipTipsDeActiveUser = !empty($row->RelationshipTipsDeActiveUser) ? $row->RelationshipTipsDeActiveUser : 0;

        }
    } ?>

    <div class="state-overview registration-count">
        <div class="row">
            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/DailyNews.jpg" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($DailyNewsTotalUser,0); ?></h1>-->
                            <h6>Daily News</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($DailyNewsTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($DailyNewsActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($DailyNewsDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/Horoscope.jpg" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($HoroscopeTotalUser,0); ?></h1>-->
                            <h6>Horoscope</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($HoroscopeTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($HoroscopeActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($HoroscopeDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/Word.jpg" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($WordOfTheDayTotalUser,0); ?></h1>-->
                            <h6>Word of the day</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($WordOfTheDayTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($WordOfTheDayActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($WordOfTheDayDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>

            </div>


        </div>

        <div class="row">
            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/LoveQuotes.jpg" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($LoveQuotesTotalUser,0); ?></h1>-->
                            <h6>Love Quotes</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($LoveQuotesTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($LoveQuotesActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($LoveQuotesDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/TazaKhobor.png" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($TazaKhoborTotalUser,0); ?></h1>-->
                            <h6>Taza Khobor</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($TazaKhoborTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($TazaKhoborActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($TazaKhoborDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/RelationshipTips.jpg" alt="Smiley face" height="135" width="115">
                            <!--<h1><?php echo number_format($RelationshipTipsTotalUser,0); ?></h1>-->
                            <h6>Relationship Tips</h6>
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo number_format($RelationshipTipsTotalUser, 0); ?></h4>
                            <h6>Total User</h6>
                            <h4><?php echo  number_format($RelationshipTipsActiveUser, 0); ?></h4>
                            <h6>Active User</h6>
                            <h4><?php echo  number_format($RelationshipTipsDeActiveUser, 0); ?></h4>
                            <h6>DeActive User</h6>
                        </div>
                    </div>
                </div>

            </div>


        </div>

        </div>

    <!--
    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class="count1"><?php echo $WordOfTheDayTotalUser; ?></h1>
                <h6>Word of the day</h6>
            </div>

        </section>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo $LoveQuotesTotalUser; ?></h1>
                <h6>Love Quotes</h6>
            </div>
        </section>
    </div>
    -->


</div>