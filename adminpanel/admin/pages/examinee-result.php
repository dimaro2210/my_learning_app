<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <?php 
                            $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
                            if($class_id) {
                                $selClass = $conn->query("SELECT * FROM class_tbl WHERE class_id='$class_id'")->fetch(PDO::FETCH_ASSOC);
                                echo "EXAMINEE RESULTS - " . ($selClass ? strtoupper($selClass['class_name']) : 'UNKNOWN');
                            } else {
                                echo "EXAMINEE RESULTS";
                            }
                        ?>
                    </div>
                </div>
                <?php if($class_id): ?>
                <div class="page-title-actions">
                    <a href="home.php?page=examinee-result" class="btn btn-sm btn-outline-primary">
                        <i class="metismenu-icon" data-lucide="arrow-left"></i> Back to Classes
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>        
        
        <?php if(!$class_id): ?>
        <!-- Class Selection Cards -->
        <div class="row">
            <?php 
                $selClasses = $conn->query("SELECT * FROM class_tbl WHERE class_name IN ('JSS 3', 'SS 1', 'SS 2', 'SS 3') ORDER BY class_id ASC");
                $colors = ['bg-midnight-bloom', 'bg-arielle-smile', 'bg-grow-early', 'bg-premium-dark'];
                $icons = ['file-text', 'check-square', 'trending-up', 'award'];
                $i = 0;
                while($clsRow = $selClasses->fetch(PDO::FETCH_ASSOC)):
                    $clsId = $clsRow['class_id'];
                    $clsName = $clsRow['class_name'];
                    $color = $colors[$i % 4];
                    $icon = $icons[$i % 4];
                    $i++;
            ?>
            <div class="col-md-6 col-xl-3 mb-3">
                <div class="card widget-content <?php echo $color; ?> p-0" style="position: relative; border-radius: 10px; overflow: hidden; transition: transform 0.3s; min-height: 100px;">
                    <a href="home.php?page=examinee-result&class_id=<?php echo $clsId; ?>" style="text-decoration: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5; display: block;"></a>
                    <div class="widget-content-wrapper text-white p-3">
                        <div class="widget-content-left">
                            <div class="widget-heading" style="font-size: 1.4rem; font-weight: 700;"><?php echo $clsName; ?></div>
                            <div class="widget-subheading opacity-7">View Exam Results</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white" style="opacity: 0.3;">
                                <i data-lucide="<?php echo $icon; ?>" style="width: 40px; height: 40px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php else: ?>
        <!-- Results Table for Selected Class -->
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Results for <?php echo $selClass['class_name']; ?></div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Exam Name</th>
                                <th>Scores</th>
                                <th>Ratings</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $selExmne = $conn->query("SELECT * FROM examinee_tbl et INNER JOIN exam_attempt ea ON et.exmne_id = ea.exmne_id WHERE et.exmne_class_id = '$class_id' ORDER BY ea.examat_id DESC ");
                            if($selExmne->rowCount() > 0)
                            {
                                while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                       <td><?php echo strtoupper($selExmneRow['exmne_fullname']); ?></td>
                                       <td>
                                         <?php 
                                            $eid = $selExmneRow['exmne_id'];
                                            $exam_id = $selExmneRow['exam_id'];
                                            $selExName = $conn->query("SELECT * FROM exam_tbl WHERE ex_id='$exam_id' ")->fetch(PDO::FETCH_ASSOC);
                                            echo $selExName['ex_title'];
                                          ?>
                                       </td>
                                       <td>
                                            <?php 
                                            $selScore = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN exam_answers ea ON eqt.eqt_id = ea.quest_id AND eqt.exam_answer = ea.exans_answer  WHERE ea.axmne_id='$eid' AND ea.exam_id='$exam_id' AND ea.exans_status='new' ");
                                            $score = $selScore->rowCount();
                                            $over = $selExName['ex_questlimit_display'];
                                            ?>
                                            <span class="font-weight-bold"><?php echo $score; ?></span> / <?php echo $over; ?>
                                       </td>
                                       <td>
                                            <span class="badge badge-info">
                                                <?php 
                                                    $ans = ($over > 0) ? ($score / $over * 100) : 0;
                                                    echo number_format($ans,2);
                                                    echo "%";
                                                 ?>
                                            </span> 
                                       </td>
                                    </tr>
                                <?php }
                            }
                            else
                            { ?>
                                <tr>
                                  <td colspan="4" class="text-center p-5">
                                    <div class="text-muted">No results found for this class.</div>
                                  </td>
                                </tr>
                            <?php }
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
