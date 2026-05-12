
<div class="app-main__outer">
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-rocket icon-gradient bg-mean-fruit"></i>
                </div>
                <div>Welcome, <?php echo $selExmneeData['exmne_fullname']; ?>!
                    <div class="page-title-subheading">Here's your learning dashboard overview.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <?php
            $exmneClass = (int)($selExmneeData['exmne_class_id']);
            $subjectsOffered = $conn->query("SELECT COUNT(*) as cnt FROM course_tbl")->fetch(PDO::FETCH_ASSOC);
            
            // Filter by class
            $stmtAvailCount = $conn->prepare("SELECT COUNT(*) as cnt FROM exam_tbl WHERE ex_class_id = ?");
            $stmtAvailCount->execute([$exmneClass]);
            $availableExams = $stmtAvailCount->fetch(PDO::FETCH_ASSOC);

            $stmtTaken = $conn->prepare("SELECT COUNT(*) as cnt FROM exam_attempt WHERE exmne_id = ?");
            $stmtTaken->execute([$exmneId]);
            $takenExams = $stmtTaken->fetch(PDO::FETCH_ASSOC);

            $prevPosition = "N/A"; // TODO: implement ranking
        ?>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Subjects Offered</div>
                        <div class="widget-subheading">For this term</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $subjectsOffered['cnt']; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Available Exams</div>
                        <div class="widget-subheading">To be taken</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $availableExams['cnt']; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Exams Taken</div>
                        <div class="widget-subheading">Per term</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $takenExams['cnt']; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-premium-dark">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Position</div>
                        <div class="widget-subheading">Previous term</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><span><?php echo $prevPosition; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row">
        <!-- Available Exams -->
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"></i>
                    Available Exams
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Exam Title</th>
                                <th class="text-center">Time (min)</th>
                                <th class="text-center">Questions</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $stmtAvail  = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_class_id = ? ORDER BY ex_id DESC");
                            $stmtAvail->execute([$exmneClass]);
                            $selAvailExams = $stmtAvail;
                            if ($selAvailExams->rowCount() > 0) {
                                while ($examRow = $selAvailExams->fetch(PDO::FETCH_ASSOC)) {
                                    $stmtCheck = $conn->prepare("SELECT * FROM exam_attempt WHERE exmne_id = ? AND exam_id = ?");
                                    $stmtCheck->execute([$exmneId, $examRow['ex_id']]);
                                    $isTaken = $stmtCheck->rowCount() > 0;
                        ?>
                            <tr>
                                <td>
                                    <b><?php echo $examRow['ex_title']; ?></b>
                                    <div class="text-muted" style="font-size: 11px;"><?php echo $examRow['ex_description']; ?></div>
                                </td>
                                <td class="text-center"><?php echo $examRow['ex_time_limit']; ?></td>
                                <td class="text-center"><?php echo $examRow['ex_questlimit_display']; ?></td>
                                <td class="text-center">
                                    <?php if($isTaken) { ?>
                                        <span class="badge badge-success">Completed</span>
                                    <?php } else { ?>
                                        <a href="#" class="btn btn-sm btn-primary startQuizBtn" data-id="<?php echo $examRow['ex_id']; ?>">Start</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } } else { ?>
                            <tr><td colspan="4" class="text-center p-3 text-muted">No exams available for your course yet.</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Scores -->
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-chart-bars icon-gradient bg-love-kiss"></i>
                    Recent Scores
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Exam</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $stmtRecent = $conn->prepare("SELECT * FROM exam_tbl et INNER JOIN exam_attempt ea ON et.ex_id = ea.exam_id WHERE ea.exmne_id = ? ORDER BY ea.examat_id DESC LIMIT 5");
                            $stmtRecent->execute([$exmneId]);
                            $selRecentScores = $stmtRecent;
                            if ($selRecentScores->rowCount() > 0) {
                                while ($recentRow = $selRecentScores->fetch(PDO::FETCH_ASSOC)) {
                                    $rExamId  = $recentRow['ex_id'];
                                    $stmtCorr = $conn->prepare("SELECT COUNT(*) as cnt FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer WHERE ea.axmne_id = ? AND ea.exam_id = ? AND ea.exans_status = 'new'");
                                    $stmtCorr->execute([$exmneId, $rExamId]);
                                    $rCorrect = $stmtCorr->fetch(PDO::FETCH_ASSOC);
                                    $rTotal = $recentRow['ex_questlimit_display'];
                                    $rPct = ($rTotal > 0) ? number_format(($rCorrect['cnt'] / $rTotal) * 100, 1) : 0;
                                    $rBadge = ($rPct >= 75) ? "badge-success" : (($rPct >= 50) ? "badge-warning" : "badge-danger");
                        ?>
                            <tr>
                                <td><b><?php echo $recentRow['ex_title']; ?></b></td>
                                <td class="text-center"><?php echo $rCorrect['cnt']; ?>/<?php echo $rTotal; ?></td>
                                <td class="text-center">
                                    <div class="badge <?php echo $rBadge; ?>"><?php echo $rPct; ?>%</div>
                                </td>
                                <td class="text-center">
                                    <a href="home.php?page=result&id=<?php echo $recentRow['ex_id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php } } else { ?>
                            <tr><td colspan="4" class="text-center p-3 text-muted">No scores yet. Take an exam to see results here.</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php if($selRecentScores->rowCount() > 0) { ?>
                <div class="d-block text-center card-footer">
                    <a href="home.php?page=result" class="btn btn-sm btn-primary">View All Results</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
