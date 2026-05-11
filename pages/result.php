<div class="app-main__outer">
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-news-paper icon-gradient bg-mean-fruit"></i>
                </div>
                <div>Result Page
                    <div class="page-title-subheading">View your academic performance report card.</div>
                </div>
            </div>
        </div>
    </div>

    <?php 
        // Handle form submission
        $showResult = false;
        $noResult = false;
        if(isset($_POST['view_result'])){
            $term = $_POST['term'];
            $year = $_POST['year'];
            $classId = $selExmneeData['exmne_class_id'];
            
            // Query result_summary
            $stmt = $conn->prepare("SELECT * FROM result_summary WHERE exmne_id=? AND class_id=? AND term=? AND year=?");
            $stmt->execute([$exmneId, $classId, $term, $year]);
            if($stmt->rowCount() > 0){
                $summary = $stmt->fetch(PDO::FETCH_ASSOC);
                $showResult = true;
                
                // Query details
                $stmtDet = $conn->prepare("SELECT d.*, c.cou_name FROM result_details d JOIN course_tbl c ON d.subject_id = c.cou_id WHERE d.summary_id=?");
                $stmtDet->execute([$summary['summary_id']]);
                $details = $stmtDet->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $noResult = true;
            }
        }
    ?>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Check Result</h5>
            <form method="post" action="home.php?page=result" class="form-inline">
                <div class="position-relative form-group mr-2 mb-2">
                    <label for="term" class="mr-2">Term</label>
                    <select name="term" id="term" class="form-control" required>
                        <option value="">Select Term</option>
                        <option value="1st Term" <?php echo (isset($term) && $term=='1st Term')?'selected':''; ?>>1st Term</option>
                        <option value="2nd Term" <?php echo (isset($term) && $term=='2nd Term')?'selected':''; ?>>2nd Term</option>
                        <option value="3rd Term" <?php echo (isset($term) && $term=='3rd Term')?'selected':''; ?>>3rd Term</option>
                    </select>
                </div>
                <div class="position-relative form-group mr-2 mb-2">
                    <label for="year" class="mr-2">Academic Year</label>
                    <select name="year" id="year" class="form-control" required>
                        <option value="">Select Year</option>
                        <?php
                            $cy = (int)date('Y');
                            for ($y = 2023; $y <= $cy + 1; $y++) {
                                $val = "$y/" . ($y+1);
                                $sel = (isset($year) && $year === $val) ? 'selected' : '';
                                echo "<option value='$val' $sel>$val</option>";
                            }
                        ?>
                    </select>
                </div>
                <button class="btn btn-primary mb-2" type="submit" name="view_result">Check Result</button>
            </form>
        </div>
    </div>

    <?php if($noResult): ?>
        <div class="alert alert-danger fade show" role="alert">
            Result not available for the selected term and year.
        </div>
    <?php endif; ?>

    <?php if($showResult): ?>
    <div class="main-card mb-3 card" id="printArea">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0 text-white text-center w-100">
                <?php echo strtoupper($summary['school_name'] ?? 'MY LEARNING SECONDARY SCHOOL'); ?><br>
                <small><?php echo $summary['location'] ?? 'Location not set'; ?></small>
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">Student Details:</h6>
                    <div><strong>Name:</strong> <?php echo $selExmneeData['exmne_fullname']; ?></div>
                    <div><strong>Class:</strong> 
                        <?php 
                            $cStmt = $conn->query("SELECT class_name FROM class_tbl WHERE class_id='$classId'");
                            echo $cStmt->fetch(PDO::FETCH_ASSOC)['class_name'] ?? 'N/A';
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 text-right">
                    <h6 class="mb-3">Term Info:</h6>
                    <div><strong>Term:</strong> <?php echo $summary['term']; ?></div>
                    <div><strong>Year:</strong> <?php echo $summary['year']; ?></div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>Subject</th>
                            <th class="text-center">C.A (40)</th>
                            <th class="text-center">Exam (60)</th>
                            <th class="text-center">Total (100)</th>
                            <th class="text-center">Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grandTotal = 0;
                        foreach($details as $d): 
                            $total = $d['total_score'];
                            $grandTotal += $total;
                            // Grade logic
                            if($total >= 70) { $grade = 'A'; $rem = 'Excellent'; }
                            elseif($total >= 60) { $grade = 'B'; $rem = 'Very Good'; }
                            elseif($total >= 50) { $grade = 'C'; $rem = 'Good'; }
                            elseif($total >= 40) { $grade = 'D'; $rem = 'Fair'; }
                            else { $grade = 'F'; $rem = 'Fail'; }
                        ?>
                        <tr>
                            <td><strong><?php echo $d['cou_name']; ?></strong></td>
                            <td class="text-center"><?php echo $d['ca_score']; ?></td>
                            <td class="text-center"><?php echo $d['exam_score']; ?></td>
                            <td class="text-center"><strong><?php echo $total; ?></strong></td>
                            <td class="text-center"><strong><?php echo $grade; ?></strong></td>
                            <td><?php echo $rem; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <table class="table table-sm table-bordered">
                        <tr><th>Attendance</th><td><?php echo $summary['attendance']; ?></td></tr>
                        <tr><th>Position/Average in Class</th><td><strong><?php echo $summary['position_or_average']; ?></strong></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr><th>Performance Remark:</th><td><?php echo $summary['performance_remark']; ?></td></tr>
                        <tr><th>Attitude Remark:</th><td><?php echo $summary['attitude_remark']; ?></td></tr>
                        <tr><th>Class Teacher:</th><td><?php echo $summary['teachers_name']; ?></td></tr>
                    </table>
                </div>
            </div>
            
        </div>
        <div class="card-footer text-center d-block">
            <button onclick="window.print();" class="btn btn-outline-primary"><i class="fa fa-print"></i> Print Result</button>
        </div>
    </div>
    <?php endif; ?>
</div>
</div>
<style>
@media print {
    .app-sidebar, .app-header, .form-inline, .card-footer { display: none !important; }
    .app-main__outer { padding: 0 !important; margin: 0 !important; }
    #printArea { width: 100%; border: none; box-shadow: none; }
}
</style>
