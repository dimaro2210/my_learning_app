<style>
    /* Prevent text selection */
    body {
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10 and IE 11 */
        user-select: none; /* Standard syntax */
    }
</style>
<script type="text/javascript" >
   function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};

    // Anti-cheating measures
    document.addEventListener('contextmenu', event => event.preventDefault()); // Prevent right click
    
    document.addEventListener('copy', event => {
        event.preventDefault(); // Prevent copy
    });
    
    document.addEventListener('keydown', function(e) {
        // Prevent F12
        if(e.keyCode == 123) {
            e.preventDefault();
            return false;
        }
        // Prevent Ctrl+Shift+I (Developer Tools)
        if(e.ctrlKey && e.shiftKey && e.keyCode == 73) {
            e.preventDefault();
            return false;
        }
        // Prevent Ctrl+U (View Source)
        if(e.ctrlKey && e.keyCode == 85) {
            e.preventDefault();
            return false;
        }
        // Prevent PrintScreen key
        if(e.key === "PrintScreen" || e.keyCode == 44) {
            navigator.clipboard.writeText("");
            alert("Screenshots are disabled during this exam.");
            e.preventDefault();
            return false;
        }
    });

    // Clear clipboard immediately if focused
    window.addEventListener('keyup', (e) => {
        if(e.key == 'PrintScreen' || e.keyCode == 44) {
            navigator.clipboard.writeText('');
        }
    });
</script>
<?php
    // Validate exam ID — cast to int to prevent SQL injection
    $examId = (int)($_GET['id'] ?? 0);
    if ($examId <= 0) { header('location:home.php'); exit; }

    $stmtExam = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = ?");
    $stmtExam->execute([$examId]);
    $selExam = $stmtExam->fetch(PDO::FETCH_ASSOC);
    if (!$selExam) { header('location:home.php'); exit; }

    $selExamTimeLimit  = $selExam['ex_time_limit'];
    $exDisplayLimit    = $selExam['ex_questlimit_display'];
?>


<div class="app-main__outer">
<div class="app-main__inner">
    <div class="col-md-12">
         <div class="app-page-title">
                <div class="page-title-wrapper" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-note2 icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            <?php echo $selExam['ex_title']; ?>
                            <div class="page-title-subheading">
                              <?php echo $selExam['ex_description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <form name="cd">
                          <input type="hidden" name="" id="timeExamLimit" value="<?php echo $selExamTimeLimit; ?>">
                          <div class="exam-timer">
                              <i class="fa fa-clock-o"></i>
                              <input style="border:none; background-color: transparent; color: var(--primary); font-size: 20px; font-weight: 700; width: 80px;" name="disp" type="text" class="clock" id="txt" value="00:00" size="5" readonly="true" />
                          </div>
                      </form> 
                    </div>   
                 </div>
            </div>  
    </div>

    <div class="col-md-12 p-0 mb-4">
        <form method="post" id="submitAnswerFrm">
            <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $examId; ?>">
            <input type="hidden" name="examAction" id="examAction" >
        <?php 
            $stmtQ = $conn->prepare("SELECT * FROM exam_question_tbl WHERE exam_id = ? ORDER BY rand() LIMIT " . (int)$exDisplayLimit);
            $stmtQ->execute([$examId]);
            $selQuest = $stmtQ;
            if($selQuest->rowCount() > 0)
            {
                $i = 1;
                while ($selQuestRow = $selQuest->fetch(PDO::FETCH_ASSOC)) { ?>
                      <?php $questId = $selQuestRow['eqt_id']; ?>
                    
                    <div class="card mb-3">
                        <div class="card-body" style="padding: 24px !important;">
                            <p style="font-weight: 600; font-size: 15px; color: #1e1e2d; margin-bottom: 16px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: rgba(124,58,237,0.1); color: #7c3aed; font-size: 13px; font-weight: 700; margin-right: 10px;"><?php echo $i++; ?></span>
                                <?php echo $selQuestRow['exam_question']; ?>
                            </p>
                            <div class="row pl-4">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding: 10px 14px; border-radius: 8px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='rgba(124,58,237,0.05)'" onmouseout="this.style.background='transparent'">
                                        <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch1']; ?>" class="form-check-input" type="radio" id="q<?php echo $questId; ?>_ch1" required >
                                        <label class="form-check-label" for="q<?php echo $questId; ?>_ch1" style="cursor:pointer; padding-left: 6px;">
                                            <?php echo $selQuestRow['exam_ch1']; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding: 10px 14px; border-radius: 8px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='rgba(124,58,237,0.05)'" onmouseout="this.style.background='transparent'">
                                        <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch2']; ?>" class="form-check-input" type="radio" id="q<?php echo $questId; ?>_ch2" required >
                                        <label class="form-check-label" for="q<?php echo $questId; ?>_ch2" style="cursor:pointer; padding-left: 6px;">
                                            <?php echo $selQuestRow['exam_ch2']; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding: 10px 14px; border-radius: 8px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='rgba(124,58,237,0.05)'" onmouseout="this.style.background='transparent'">
                                        <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch3']; ?>" class="form-check-input" type="radio" id="q<?php echo $questId; ?>_ch3" required >
                                        <label class="form-check-label" for="q<?php echo $questId; ?>_ch3" style="cursor:pointer; padding-left: 6px;">
                                            <?php echo $selQuestRow['exam_ch3']; ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding: 10px 14px; border-radius: 8px; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='rgba(124,58,237,0.05)'" onmouseout="this.style.background='transparent'">
                                        <input name="answer[<?php echo $questId; ?>][correct]" value="<?php echo $selQuestRow['exam_ch4']; ?>" class="form-check-input" type="radio" id="q<?php echo $questId; ?>_ch4" required >
                                        <label class="form-check-label" for="q<?php echo $questId; ?>_ch4" style="cursor:pointer; padding-left: 6px;">
                                            <?php echo $selQuestRow['exam_ch4']; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }
                ?>
                    <div class="card">
                        <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                            <button type="button" class="btn btn-warning" id="resetExamFrm" style="padding: 10px 28px !important;">
                                <i class="fa fa-refresh"></i> Reset
                            </button>
                            <input name="submit" type="submit" value="Submit Answers" class="btn btn-primary" id="submitAnswerFrmBtn" style="padding: 10px 32px !important;">
                        </div>
                    </div>

                <?php
            }
            else
            { ?>
                <div class="card">
                    <div class="card-body text-center p-5">
                        <i class="pe-7s-info" style="font-size: 48px; color: #9ca3af;"></i>
                        <h5 class="mt-3 text-muted">No questions available at this moment</h5>
                    </div>
                </div>
            <?php }
         ?>   

        </form>
    </div>
</div>
 
