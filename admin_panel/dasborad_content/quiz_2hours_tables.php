<?php
$totalQuizUser = json_decode(file_get_contents($totalQuizUserUrl));

$topScorer = json_decode(file_get_contents($topScorerUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']));
$ReportingCategoryName = json_decode(file_get_contents($quizCategoryNameUrl . "?organization_id=" . $_SESSION['admin_login_info']['organization_id']), true);
$catIdList = '';
foreach ($ReportingCategoryName as $catId => $catName) {
    $catIdList .= $catId . ",";
}
$catIdList = rtrim($catIdList, ',');

$quizActiveUser = json_decode(file_get_contents($quizActivationUrl . "?quiz_category_id=" . $catIdList));
?>

<div class="row">

    <div class="col-lg-4">
        <!--user info table start-->
        <section class="panel">
            <div class="panel-body">
                <img class="task-thumb" src="<?php echo $dashBoardQuizActivationImgUrl; ?>" alt=""
                     width="90"
                     height="83">

                <div class="task-thumb-details">
                    <h1>Active Users</h1>
                    <p>Last 2 Hours</p>
                </div>
            </div>
            <?php if (!empty($quizActiveUser)) { ?>
                <table class="table table-hover personal-task">
                    <tbody>
                    <?php foreach ($quizActiveUser as $key => $row) { ?>
                        <tr>
                            <td>
                                <i class=" fa fa-tasks"></i>
                            </td>
                            <td><?php echo $row->q_title ?></td>
                            <td><?php echo $row->cnt ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </section>
        <!--user info table end-->
    </div>

    <div class="col-lg-8">
        <!--work progress start-->
        <section class="panel">
            <div class="panel-body">
                <img class="task-thumb" src="<?php echo $dashBoardQuizTopScorerImgUrl; ?>" alt=""
                     width="90"
                     height="83">
                <div class="task-thumb-details">
                    <h1>Top 5 Quiz Scorer</h1>
                    <p>Last 2 Hours</p>
                </div>
            </div>
            <?php if (!empty($topScorer)) { ?>
                <table class="display table table-bordered dataTable" id="my_dynamic_table">

                    <thead>
                    <tr class="">
                        <th width="5%"><span class="badge bg-info">SL</span></th>
                        <th width="10%"><span class="badge bg-info">Quiz Category</span></th>
                        <th width="10%"><span class="badge bg-info">Quiz Title</span></th>
                        <th width="10%"><span class="badge bg-info">MSISDN</span></th>
                        <th width="10%"><span class="badge bg-info">Start Time</span></th>
                        <th width="10%"><span class="badge bg-info">End Time</span></th>
                        <th width="10%"><span class="badge bg-info">Duration</span></th>
                        <th width="10%"><span class="badge bg-info">Score</span></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($topScorer as $key => $row) {

                        $quizCategoryName = !empty($row->quiz_category_name) ? $row->quiz_category_name : "";
                        $quizTitle = !empty($row->quiz_title) ? $row->quiz_title : "";
                        $MSISDN = !empty($row->msisdn) ? $row->msisdn : "";
                        $startTime = !empty($row->start_time) ? $row->start_time : "";
                        $endTime = !empty($row->end_time) ? $row->end_time : "";
                        $duration = !empty($row->duration) ? $row->duration : "";
                        $score = !empty($row->Score) ? $row->Score : "";
                        ?>
                        <tr class="gradeX">
                            <td><?php echo $key + 1; ?></td>

                            <td>
                                <?php echo $quizCategoryName; ?>
                            </td>
                            <td>
                                <?php echo $quizTitle; ?>
                            </td>

                            <td>
                                <?php echo $MSISDN; ?>
                            </td>

                            <td>
                                <?php echo $startTime; ?>
                            </td>

                            <td>
                                <?php echo $endTime; ?>
                            </td>
                            <td>
                                <?php echo $duration; ?>
                            </td>
                            <td>
                                <?php echo $score; ?>
                            </td>

                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            <?php } ?>
        </section>
        <!--work progress end-->
    </div>
</div>