
<div class="app-main__outer">
<div class="app-main__inner">
    <div id="refreshData">
    <div class="col-md-12">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-graph1 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>My Scores
                        <div class="page-title-subheading">View all your exam results and performance history.</div>
                    </div>
                </div>
            </div>
        </div>  
    </div>

    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Exam Score History</div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Exam Title</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Total Questions</th>
                            <th class="text-center">Percentage</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $selMyScores = $conn->query("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id = ea.exam_id WHERE ea.exmne_id='$exmneId' ORDER BY ea.examat_id DESC");
                        
                        if($selMyScores->rowCount() > 0) {
                            $i = 1;
                            while ($scoreRow = $selMyScores->fetch(PDO::FETCH_ASSOC)) { 
                                // Get correct answers count
                                $examId = $scoreRow['ex_id'];
                                $selCorrect = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id='$exmneId' AND ea.exam_id='$examId' AND ea.exans_status='new'");
                                $correctCount = $selCorrect->rowCount();
                                $totalQuestions = $scoreRow['ex_questlimit_display'];
                                
                                if($totalQuestions > 0) {
                                    $percentage = number_format(($correctCount / $totalQuestions) * 100, 1);
                                } else {
                                    $percentage = "0.0";
                                }
                                
                                // Determine status badge
                                if($percentage >= 75) {
                                    $badge = "badge-success";
                                    $status = "Passed";
                                } elseif($percentage >= 50) {
                                    $badge = "badge-warning";
                                    $status = "Average";
                                } else {
                                    $badge = "badge-danger";
                                    $status = "Failed";
                                }
                    ?>
                        <tr>
                            <td class="text-center text-muted"><?php echo $i++; ?></td>
                            <td><b><?php echo $scoreRow['ex_title']; ?></b>
                                <div class="text-muted" style="font-size: 12px;"><?php echo $scoreRow['ex_description']; ?></div>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px; font-weight: bold;"><?php echo $correctCount; ?></span>
                            </td>
                            <td class="text-center"><?php echo $totalQuestions; ?></td>
                            <td class="text-center">
                                <span style="font-size: 16px; font-weight: bold;"><?php echo $percentage; ?>%</span>
                            </td>
                            <td class="text-center">
                                <div class="badge <?php echo $badge; ?>"><?php echo $status; ?></div>
                            </td>
                            <td class="text-center">
                                <a href="home.php?page=result&id=<?php echo $scoreRow['ex_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php }
                        } else { ?>
                        <tr>
                            <td colspan="7" class="text-center p-4">
                                <h5 class="text-muted">No exam scores yet</h5>
                                <p class="text-muted">Take an exam from the sidebar to see your scores here.</p>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($selMyScores->rowCount() > 0) { ?>
    <!-- Summary Cards -->
    <div class="row col-md-12 mt-3">
        <?php
            // Calculate overall stats
            $totalExams = $selMyScores->rowCount();
            $selAllCorrect = $conn->query("SELECT COUNT(*) as total FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id='$exmneId' AND ea.exans_status='new'");
            $allCorrectRow = $selAllCorrect->fetch(PDO::FETCH_ASSOC);
            $totalCorrect = $allCorrectRow['total'];

            $selAllAnswered = $conn->query("SELECT COUNT(*) as total FROM exam_answers WHERE axmne_id='$exmneId' AND exans_status='new'");
            $allAnsweredRow = $selAllAnswered->fetch(PDO::FETCH_ASSOC);
            $totalAnswered = $allAnsweredRow['total'];

            $overallPct = $totalAnswered > 0 ? number_format(($totalCorrect / $totalAnswered) * 100, 1) : 0;
        ?>
        <div class="col-md-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Exams Taken</div>
                        <div class="widget-subheading">Total completed</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $totalExams; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Correct Answers</div>
                        <div class="widget-subheading">Out of <?php echo $totalAnswered; ?> questions</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $totalCorrect; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Overall Score</div>
                        <div class="widget-subheading">Average performance</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $overallPct; ?>%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    </div>
</div>
