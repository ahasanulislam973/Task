<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/audra_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $Total_Unique_Users = !empty($row->Total_Unique_Users) ? $row->Total_Unique_Users : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $About_Us = !empty($row->About_Us) ? $row->About_Us : 0;
            $Get_Now = !empty($row->Get_Now) ? $row->Get_Now : 0;
            $How_to = !empty($row->How_to) ? $row->How_to : 0;
			$Visit_Social = !empty($row->Visit_Social) ? $row->Visit_Social : 0;
			$Download = !empty($row->Download) ? $row->Download : 0;
			$Know_More = !empty($row->Know_More) ? $row->Know_More : 0;
			//$PhotographyCourse = !empty($row->PhotographyCourse) ? $row->PhotographyCourse : 0;
			//$AcademicCourse = !empty($row->AcademicCourse) ? $row->AcademicCourse : 0;
			//$ForeignLanguageCourse = !empty($row->ForeignLanguageCourse) ? $row->ForeignLanguageCourse : 0;
			//$IELTSSpeaking = !empty($row->IELTSSpeaking) ? $row->IELTSSpeaking : 0;
			//$IELTSAcademicWritingTask1 = !empty($row->IELTSAcademicWritingTask1) ? $row->IELTSAcademicWritingTask1 : 0;
			//$IELTSAcademicPreparation_writing = !empty($row->IELTSAcademicPreparation_writing) ? $row->IELTSAcademicPreparation_writing : 0;
			//$IELTSAcademicGeneralTrainingWritingTask2_KorteChai = !empty($row->IELTSAcademicGeneralTrainingWritingTask2_KorteChai) ? $row->IELTSAcademicGeneralTrainingWritingTask2_KorteChai : 0;
			//$IELTSGeneralTrainingFullCourse_KorteChai = !empty($row->IELTSGeneralTrainingFullCourse_KorteChai) ? $row->IELTSGeneralTrainingFullCourse_KorteChai : 0;
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
                <h1 class=" count4"><?php echo number_format($About_Us); ?></h1>
                <h6>About Us</h6>
            </div>
        </section>
    </div>


	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Get_Now); ?></h1>
                <h6>Get Now</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($How_to); ?></h1>
                <h6>How to</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Visit_Social); ?></h1>
                <h6>Visit Social </h6>
            </div>
        </section>
    </div> 

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Download); ?></h1>
                <h6>Download</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($Know_More); ?></h1>
                <h6>Know More</h6>
            </div>
        </section>
    </div>

    <!--<div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($PhotographyCourse); ?></h1>
                <h6>Photography Course</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($AcademicCourse); ?></h1>
                <h6>Academic Course</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ForeignLanguageCourse); ?></h1>
                <h6>Foreign Language Course</h6>
            </div>
        </section>
    </div>

    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($IELTSSpeaking); ?></h1>
                <h6>IELTS Speaking</h6>
            </div>
        </section>
    </div> -->

    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($IELTSAcademicWritingTask1); ?></h1>
                <h6>IELTS Academic Writing Task1</h6>
            </div>
        </section>
    </div> -->

    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($IELTSAcademicPreparation_writing); ?></h1>
                <h6>IELTS Academic Preparation_writing</h6>
            </div>
        </section>
    </div> -->
    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($IELTSAcademicGeneralTrainingWritingTask2_KorteChai); ?></h1>
                <h6>IELTS Academic General Training WritingTask2</h6>
            </div>
        </section>
    </div> -->
    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($IELTSGeneralTrainingFullCourse_KorteChai); ?></h1>
                <h6>IELTS General Training FullCourse_KorteChai</h6>
            </div>
        </section>
    </div> -->
    
</div>