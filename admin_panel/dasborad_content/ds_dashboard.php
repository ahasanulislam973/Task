<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/ds_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $total_unique_user = !empty($row->total_unique_user) ? $row->total_unique_user : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $Quiz_Contest = !empty($row->Quiz_Contest) ? $row->Quiz_Contest : 0;
            $Ghoori_Learning = !empty($row->Ghoori_Learning) ? $row->Ghoori_Learning : 0;
			$Dainik_Shiksha = !empty($row->Dainik_Shiksha) ? $row->Dainik_Shiksha : 0;
			$Online_Vote = !empty($row->Online_Vote) ? $row->Online_Vote : 0;
			$QuizTime_KhelteChai = !empty($row->QuizTime_KhelteChai) ? $row->QuizTime_KhelteChai : 0;
			$LiveUpdate_DekhteChai = !empty($row->LiveUpdate_DekhteChai) ? $row->LiveUpdate_DekhteChai : 0;
			$Chakrir_Khobor = !empty($row->Chakrir_Khobor) ? $row->Chakrir_Khobor : 0;
			$InstitutionUpdate_JanteChai = !empty($row->InstitutionUpdate_JanteChai) ? $row->InstitutionUpdate_JanteChai : 0;
			$Porikhkta = !empty($row->Porikhkta) ? $row->Porikhkta : 0;
			$Vorti = !empty($row->Vorti) ? $row->Vorti : 0;
			$ShikhkhokNibondon = !empty($row->ShikhkhokNibondon) ? $row->ShikhkhokNibondon : 0;
			$School = !empty($row->School) ? $row->School : 0;
			$College = !empty($row->College) ? $row->College : 0;
			$Madrasha = !empty($row->Madrasha) ? $row->Madrasha : 0;
			$University = !empty($row->University) ? $row->University : 0;
        }
    } ?>

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
                <h6>Total Subscribers</h6>
            </div>
        </section>
    </div>


	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Quiz_Contest); ?></h1>
                <h6>Quiz Contest</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Ghoori_Learning); ?></h1>
                <h6>Ghoori Learning</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Dainik_Shiksha); ?></h1>
                <h6>Dainik Shiksha Procchod</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Online_Vote); ?></h1>
                <h6>Online Vote</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($LiveUpdate_DekhteChai); ?></h1>
                <h6>LiveUpdate</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($VacancyNews_JanteChai); ?></h1>
                <h6>Exam & Vacancy News </h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($InstitutionUpdate_JanteChai); ?></h1>
                <h6>InstitutionUpdate</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Porikhkta); ?></h1>
                <h6>Porikkhar Khobor</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Vorti); ?></h1>
                <h6>Vorti Khobor</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ShikhkhokNibondon); ?></h1>
                <h6>Shikhkhok Nibondon</h6>
            </div>
        </section>
    </div>
	 <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Chakrir_Khobor); ?></h1>
                <h6>Chakrir Khobor</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($School); ?></h1>
                <h6>School Update</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($College); ?></h1>
                <h6>College Update</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Madrasha); ?></h1>
                <h6>Madrasha Update</h6>
            </div>
        </section>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($University); ?></h1>
                <h6>University Update</h6>
            </div>
        </section>
    </div>

</div>