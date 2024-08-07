<?php
$jagofmDashboardReportURL = $baseUrl . "reporting/ghoori_DashboardReport.php";
$totalUser = json_decode(file_get_contents($jagofmDashboardReportURL));
?>

<div class="row state-overview">

    <?php if (!empty($totalUser)) {
        foreach ($totalUser as $key => $row) {
            $Total_Subscribers = !empty($row->Total_Subscribers) ? $row->Total_Subscribers : 0;
            $Total_Interactions = !empty($row->Total_Interactions) ? $row->Total_Interactions : 0;
            $CertificateCourse = !empty($row->CertificateCourse) ? $row->CertificateCourse : 0;
            $GhooriLearningKi = !empty($row->GhooriLearningKi) ? $row->GhooriLearningKi : 0;
            $KothaBolteCae = !empty($row->KothaBolteCae) ? $row->KothaBolteCae : 0;
			$MainMenu = !empty($row->MainMenu) ? $row->MainMenu : 0;
			$FreelancingCourse = !empty($row->FreelancingCourse) ? $row->FreelancingCourse : 0;
			$ProfessionalCourse = !empty($row->ProfessionalCourse) ? $row->ProfessionalCourse : 0;
			$PhotographyCourse = !empty($row->PhotographyCourse) ? $row->PhotographyCourse : 0;
			$AcademicCourse = !empty($row->AcademicCourse) ? $row->AcademicCourse : 0;
			$ForeignLanguageCourse = !empty($row->ForeignLanguageCourse) ? $row->ForeignLanguageCourse : 0;
			$IELTSSpeaking = !empty($row->IELTSSpeaking) ? $row->IELTSSpeaking : 0;
			$IELTSAcademicWritingTask1 = !empty($row->IELTSAcademicWritingTask1) ? $row->IELTSAcademicWritingTask1 : 0;
			$IELTSAcademicPreparation_writing = !empty($row->IELTSAcademicPreparation_writing) ? $row->IELTSAcademicPreparation_writing : 0;
			$IELTSAcademicGeneralTrainingWritingTask2_KorteChai = !empty($row->IELTSAcademicGeneralTrainingWritingTask2_KorteChai) ? $row->IELTSAcademicGeneralTrainingWritingTask2_KorteChai : 0;
			$IELTSGeneralTrainingFullCourse_KorteChai = !empty($row->IELTSGeneralTrainingFullCourse_KorteChai) ? $row->IELTSGeneralTrainingFullCourse_KorteChai : 0;
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
                <h1 class=" count4"><?php echo number_format($CertificateCourse); ?></h1>
                <h6>Certificate Course</h6>
            </div>
        </section>
    </div>


	    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($GhooriLearningKi); ?></h1>
                <h6>Ghoori Learning Web</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($KothaBolteCae); ?></h1>
                <h6>Customer Support</h6>
            </div>
        </section>
    </div>

    <!-- <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($MainMenu); ?></h1>
                <h6>Main Menu </h6>
            </div>
        </section>
    </div> -->

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($FreelancingCourse); ?></h1>
                <h6>Freelancing Course</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4"><?php echo number_format($ProfessionalCourse); ?></h1>
                <h6>Professional Course</h6>
            </div>
        </section>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-6">
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