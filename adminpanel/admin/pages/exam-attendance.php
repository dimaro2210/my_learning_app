<?php 
    $exId = $_GET['id'];
    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exId'")->fetch(PDO::FETCH_ASSOC);
    $examTitle = $selExam['ex_title'];
?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon" data-lucide="users" style="color:var(--primary);"></i>
                    </div>
                    <div>EXAM ATTENDANCE
                        <div class="page-title-subheading">View list of students who have participated in <strong><?php echo $examTitle; ?></strong></div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="home.php?page=manage-exam&class_id=<?php echo $selExam['ex_class_id']; ?>" class="btn btn-sm btn-outline-primary">
                        <i class="metismenu-icon" data-lucide="arrow-left"></i> Back to Exams
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Student Participation List</div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Student Fullname</th>
                                <th>Gender</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Date/Time Taken</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $selAttempt = $conn->query("SELECT e.*, ea.examat_id, (SELECT MIN(ans.exans_created) FROM exam_answers ans WHERE ans.axmne_id = e.exmne_id AND ans.exam_id = ea.exam_id) AS date_taken FROM examinee_tbl e INNER JOIN exam_attempt ea ON e.exmne_id = ea.exmne_id WHERE ea.exam_id = '$exId' ORDER BY ea.examat_id DESC");
                                
                                if($selAttempt->rowCount() > 0) {
                                    while ($row = $selAttempt->fetch(PDO::FETCH_ASSOC)) { 
                                        $exmneId = $row['exmne_id'];
                                        
                                        // Calculate score
                                        $stmtCorr = $conn->prepare("SELECT COUNT(*) as cnt FROM exam_question_tbl eqt INNER JOIN exam_answers eans ON eqt.eqt_id = eans.quest_id AND eqt.exam_answer = eans.exans_answer WHERE eans.axmne_id = ? AND eans.exam_id = ?");
                                        $stmtCorr->execute([$exmneId, $exId]);
                                        $correct = $stmtCorr->fetch(PDO::FETCH_ASSOC)['cnt'];
                                        $total = $selExam['ex_questlimit_display'];
                                        $pct = ($total > 0) ? number_format(($correct / $total) * 100, 1) : 0;
                            ?>
                            <tr>
                                <td><div class="font-weight-bold text-primary"><?php echo strtoupper($row['exmne_fullname']); ?></div></td>
                                <td><?php echo strtoupper($row['exmne_gender']); ?></td>
                                <td><span class="badge badge-info"><?php echo $correct; ?> / <?php echo $total; ?></span></td>
                                <td>
                                    <div class="font-weight-bold <?php echo $pct >= 50 ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo $pct; ?>%
                                    </div>
                                </td>
                                <td><?php echo $row['date_taken'] ? date("M d, Y - h:i A", strtotime($row['date_taken'])) : 'N/A'; ?></td>
                                <td><span class="badge badge-success">COMPLETED</span></td>
                            </tr>
                            <?php }
                                } else { ?>
                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    <div class="text-muted">No students have taken this exam yet.</div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if(typeof lucide !== 'undefined') lucide.createIcons();
</script>
