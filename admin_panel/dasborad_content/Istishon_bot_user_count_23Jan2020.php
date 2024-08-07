<?php
$totalUser = json_decode(file_get_contents($istishonBotTotalUrl));
?>

<style  type="text/css">
    .table {
        border: 1px solid black;
    }

    .table thead th {
        border-top: 1px solid #000!important;
        border-bottom: 1px solid #000!important;
        border-left: 1px solid #000!important;
        border-right: 1px solid #000!important;
    }

    .table td {
        border-left: 1px solid #000;
        border-right:1px solid #000;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }

</style>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {

            $TotalUser = !empty($row->TotalUser) ? $row->TotalUser : 0;
            $TodayRegistrationCount = !empty($row->TodayRegistrationCount) ? $row->TodayRegistrationCount : 0;

            $ThisWeekTotalUser = !empty($row->ThisWeekTotalUser) ? $row->ThisWeekTotalUser : 0;
            $PastWeekTotalUser = !empty($row->PastWeekTotalUser) ? $row->PastWeekTotalUser : 0;
            $TodayDeRegistrationCount = !empty($row->TodayDeRegistrationCount) ? $row->TodayDeRegistrationCount : 0;

            $ThisMonthTotalUser = !empty($row->ThisMonthTotalUser) ? $row->ThisMonthTotalUser : 0;
            $PastMonthTotalUser = !empty($row->PastMonthTotalUser) ? $row->PastMonthTotalUser : 0;

            $DailyNewsTotalUser = !empty($row->DailyNewsTotalUser) ? $row->DailyNewsTotalUser : 0;
			$DailyNewsActiveUser = !empty($row->DailyNewsActiveUser) ? $row->DailyNewsActiveUser : 0;
			$DailyNewsDeActiveUser = !empty($row->DailyNewsDeActiveUser) ? $row->DailyNewsDeActiveUser : 0;

            $TodayDailyNewsTotalUser = !empty($row->TodayDailyNewsTotalUser) ? $row->TodayDailyNewsTotalUser : 0;
            $TodayDailyNewsActiveUser = !empty($row->TodayDailyNewsActiveUser) ? $row->TodayDailyNewsActiveUser : 0;
            $TodayDailyNewsDeActiveUser = !empty($row->TodayDailyNewsDeActiveUser) ? $row->TodayDailyNewsDeActiveUser : 0;


            $HoroscopeTotalUser = !empty($row->HoroscopeTotalUser) ? $row->HoroscopeTotalUser : 0;
			$HoroscopeActiveUser = !empty($row->HoroscopeActiveUser) ? $row->HoroscopeActiveUser : 0;
			$HoroscopeDeActiveUser = !empty($row->HoroscopeDeActiveUser) ? $row->HoroscopeDeActiveUser : 0;

            $TodayHoroscopeTotalUser = !empty($row->TodayHoroscopeTotalUser) ? $row->TodayHoroscopeTotalUser : 0;
            $TodayHoroscopeActiveUser = !empty($row->TodayHoroscopeActiveUser) ? $row->TodayHoroscopeActiveUser : 0;
            $TodayHoroscopeDeActiveUser = !empty($row->TodayHoroscopeDeActiveUser) ? $row->TodayHoroscopeDeActiveUser : 0;
			
            $WordOfTheDayTotalUser = !empty($row->WordOfTheDayTotalUser) ? $row->WordOfTheDayTotalUser : 0;
            $WordOfTheDayActiveUser = !empty($row->WordOfTheDayActiveUser) ? $row->WordOfTheDayActiveUser : 0;
            $WordOfTheDayDeActiveUser = !empty($row->WordOfTheDayDeActiveUser) ? $row->WordOfTheDayDeActiveUser : 0;


            $TodayWordOfTheDayTotalUser = !empty($row->TodayWordOfTheDayTotalUser) ? $row->TodayWordOfTheDayTotalUser : 0;
            $TodayWordOfTheDayActiveUser = !empty($row->TodayWordOfTheDayActiveUser) ? $row->TodayWordOfTheDayActiveUser : 0;
            $TodayWordOfTheDayDeActiveUser = !empty($row->TodayWordOfTheDayDeActiveUser) ? $row->TodayWordOfTheDayDeActiveUser : 0;

            $LoveQuotesTotalUser = !empty($row->LoveQuotesTotalUser) ? $row->LoveQuotesTotalUser : 0;
            $LoveQuotesActiveUser = !empty($row->LoveQuotesActiveUser) ? $row->LoveQuotesActiveUser : 0;
            $LoveQuotesDeActiveUser = !empty($row->LoveQuotesDeActiveUser) ? $row->LoveQuotesDeActiveUser : 0;

            $TodayLoveQuotesTotalUser = !empty($row->TodayLoveQuotesTotalUser) ? $row->TodayLoveQuotesTotalUser : 0;
            $TodayLoveQuotesActiveUser = !empty($row->TodayLoveQuotesActiveUser) ? $row->TodayLoveQuotesActiveUser : 0;
            $TodayLoveQuotesDeActiveUser = !empty($row->TodayLoveQuotesDeActiveUser) ? $row->TodayLoveQuotesDeActiveUser : 0;


            $TazaKhoborTotalUser = !empty($row->TazaKhoborTotalUser) ? $row->TazaKhoborTotalUser : 0;
            $TazaKhoborActiveUser = !empty($row->TazaKhoborActiveUser) ? $row->TazaKhoborActiveUser : 0;
            $TazaKhoborDeActiveUser = !empty($row->TazaKhoborDeActiveUser) ? $row->TazaKhoborDeActiveUser : 0;

            $TodayTazaKhoborTotalUser = !empty($row->TodayTazaKhoborTotalUser) ? $row->TodayTazaKhoborTotalUser : 0;
            $TodayTazaKhoborActiveUser = !empty($row->TodayTazaKhoborActiveUser) ? $row->TodayTazaKhoborActiveUser : 0;
            $TodayTazaKhoborDeActiveUser = !empty($row->TodayTazaKhoborDeActiveUser) ? $row->TodayTazaKhoborDeActiveUser : 0;


            $RelationshipTipsTotalUser = !empty($row->RelationshipTipsTotalUser) ? $row->RelationshipTipsTotalUser : 0;
            $RelationshipTipsActiveUser = !empty($row->RelationshipTipsActiveUser) ? $row->RelationshipTipsActiveUser : 0;
            $RelationshipTipsDeActiveUser = !empty($row->RelationshipTipsDeActiveUser) ? $row->RelationshipTipsDeActiveUser : 0;

            $TodayRelationshipTipsTotalUser = !empty($row->TodayRelationshipTipsTotalUser) ? $row->TodayRelationshipTipsTotalUser : 0;
            $TodayRelationshipTipsActiveUser = !empty($row->TodayRelationshipTipsActiveUser) ? $row->TodayRelationshipTipsActiveUser : 0;
            $TodayRelationshipTipsDeActiveUser = !empty($row->TodayRelationshipTipsDeActiveUser) ? $row->TodayRelationshipTipsDeActiveUser : 0;

        }
    } ?>

    <div class="state-overview registration-count">


<div class="container">

    <div class="row justify-content-md-center">

        <div class="col-md-4" style="margin-top:50px">
                     <div style="    padding: 20px;
    border: 1px solid black;
    margin-left: 128px;
    margin-top: -18px;">
                         <h7><b>Today Registration Count:</b> <?php echo number_format($TodayRegistrationCount,0); ?></h7>
                     </div>
        </div>

        <div class="col-md-4">
            <div class="row justify-content-md-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Istishon BOT User</th>
                                        <th scope="col"><b>Total : </b><?php echo number_format($TotalUser,0); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><h7><b>This Week:</b> <?php echo number_format($ThisWeekTotalUser,0); ?></h7></td>
                                        <td><h7><b>Past Week:</b> <?php echo number_format($PastWeekTotalUser,0); ?></h7></td>

                                    </tr>
                                    <tr>
                                        <td><h7><b>This Month:</b> <?php echo number_format($ThisMonthTotalUser,0); ?></h7></td>
                                        <td> <h7><b>Past Month:</b> <?php echo number_format($PastMonthTotalUser,0); ?></h7></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        </div>

        <div class="col-md-4" style="margin-top: 50px;">
            <div style="    padding: 20px;
    border:1px solid black;
    margin-right: 116px;
    margin-top: -19px;">
                <h7><b>Today DeRegistration Count:</b> <?php echo number_format($TodayDeRegistrationCount, 0); ?></h7>
            </div>
        </div>


    </div>
</div>


        <div class="row">
            <div class="col-md-12">

                <div class="value">
                    <div class="row multi-col">
                        <div class="col-md-6">
                            <h4></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" style="margin-left: -50px">
                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/DailyIslam.jpg" alt="Smiley face" height="135" width="115">
                              <h6>Daily Islam</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>
                                <h4><?php echo number_format($DailyNewsTotalUser,0);?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayDailyNewsActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayDailyNewsDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/Horoscope.jpg" alt="Smiley face" height="135" width="115">
                               <h6>Horoscope</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>

                                <h4><?php echo number_format($HoroscopeTotalUser, 0); ?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayHoroscopeActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayHoroscopeDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/Word.jpg" alt="Smiley face" height="135" width="115">
                               <h6>Word of the day</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>

                                <h4><?php echo number_format($WordOfTheDayTotalUser, 0); ?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayWordOfTheDayActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayWordOfTheDayDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div class="container"  >
            <div class="row" style="margin-left: -50px">
                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/LoveQuotes.jpg" alt="Smiley face" height="135" width="115">
                               <h6>Love Quotes</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>

                                <h4><?php echo number_format($LoveQuotesTotalUser, 0); ?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayLoveQuotesActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayLoveQuotesDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/TazaKhobor.png" alt="Smiley face" height="135" width="115">
                                <h6>Taza Khobor</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>

                                <h4><?php echo number_format($TazaKhoborTotalUser, 0); ?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayTazaKhoborActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayTazaKhoborDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="value">
                        <div class="row multi-col">
                            <div class="col-md-6"> <img src="../bot_service_panel/assets/img/Istishon/RelationshipTips.jpg" alt="Smiley face" height="135" width="115">
                                <h6>Relationship Tips</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Total User</h6>

                                <h4><?php echo number_format($RelationshipTipsTotalUser, 0); ?></h4>
                                <h6>Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayRelationshipTipsActiveUser, 0); ?></h4>
                                <h6>Un-Subscribed Today</h6>

                                <h4><?php echo  number_format($TodayRelationshipTipsDeActiveUser, 0); ?></h4>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        </div>


</div>