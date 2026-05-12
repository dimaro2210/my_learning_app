<?php 
    $exId = $_GET['id'];
    $mneId = $_GET['mne'];

    $selExam = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exId'")->fetch(PDO::FETCH_ASSOC);
    $selExmne = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$mneId'")->fetch(PDO::FETCH_ASSOC);
?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon" data-lucide="eye" style="color:var(--primary);"></i>
                    </div>
                    <div>EXAM RESULT REVIEW
                        <div class="page-title-subheading">Reviewing answers for <strong><?php echo strtoupper($selExmne['exmne_fullname']); ?></strong> in <strong><?php echo $selExam['ex_title']; ?></strong></div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="home.php?page=exam-attendance&id=<?php echo $exId; ?>" class="btn btn-sm btn-outline-primary">
                        <i class="metismenu-icon" data-lucide="arrow-left"></i> Back to Attendance
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php 
                    $selQuest = $conn->query("SELECT * FROM exam_question_tbl WHERE exam_id='$exId' ORDER BY eqt_id ASC");
                    $i = 1;
                    while ($questRow = $selQuest->fetch(PDO::FETCH_ASSOC)) {
                        $questId = $questRow['eqt_id'];
                        $selAns = $conn->query("SELECT * FROM exam_answers WHERE axmne_id='$mneId' AND exam_id='$exId' AND quest_id='$questId'")->fetch(PDO::FETCH_ASSOC);
                        
                        $studentAnswer = $selAns ? $selAns['exans_answer'] : 'NO ANSWER';
                        $correctAnswer = $questRow['exam_answer'];
                        $isCorrect = ($studentAnswer == $correctAnswer);
                ?>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title" style="display: flex; align-items: center;">
                            <span class="badge badge-secondary mr-2"><?php echo $i++; ?></span>
                            <?php echo $questRow['exam_question']; ?>
                        </h5>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded <?php echo $isCorrect ? 'bg-light border-success' : 'bg-light border-danger'; ?>">
                                    <small class="text-muted d-block mb-1">Student's Answer:</small>
                                    <div class="font-weight-bold <?php echo $isCorrect ? 'text-success' : 'text-danger'; ?>">
                                        <?php if(!$isCorrect): ?>
                                            <i class="fa fa-times-circle mr-1"></i>
                                        <?php else: ?>
                                            <i class="fa fa-check-circle mr-1"></i>
                                        <?php endif; ?>
                                        <?php echo $studentAnswer; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light border-primary">
                                    <small class="text-muted d-block mb-1">Correct Answer:</small>
                                    <div class="font-weight-bold text-primary">
                                        <i class="fa fa-check-circle mr-1"></i>
                                        <?php echo $correctAnswer; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <ul class="list-group list-group-flush">
                                <?php 
                                    $options = [
                                        'A' => $questRow['exam_ch1'],
                                        'B' => $questRow['exam_ch2'],
                                        'C' => $questRow['exam_ch3'],
                                        'D' => $questRow['exam_ch4']
                                    ];
                                    foreach($options as $key => $val):
                                        $isThisCorrect = ($val == $correctAnswer);
                                        $isThisStudentAns = ($val == $studentAnswer);
                                ?>
                                <li class="list-group-item d-flex align-items-center" style="border:none; padding: 5px 0;">
                                    <span class="mr-3 font-weight-bold <?php echo $isThisCorrect ? 'text-success' : ($isThisStudentAns ? 'text-danger' : 'text-muted'); ?>">
                                        <?php echo $key; ?>.
                                    </span>
                                    <span class="<?php echo $isThisCorrect ? 'font-weight-bold text-success' : ($isThisStudentAns ? 'font-weight-bold text-danger' : ''); ?>">
                                        <?php echo $val; ?>
                                    </span>
                                    <?php if($isThisCorrect): ?>
                                        <span class="badge badge-success ml-auto">Correct Choice</span>
                                    <?php elseif($isThisStudentAns): ?>
                                        <span class="badge badge-danger ml-auto">Student Choice</span>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    if(typeof lucide !== 'undefined') lucide.createIcons();
</script>
