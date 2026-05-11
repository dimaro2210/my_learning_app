<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon" data-lucide="file-plus-2" style="color:var(--primary);"></i>
                    </div>
                    <div>
                        <span id="pageTitleText">ADD STUDENT RESULT</span>
                        <div class="page-title-subheading">Upload a termly report card for a student.</div>
                    </div>
                </div>
                <div class="page-title-actions" id="backToClassesBtn" style="display:none;">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="showClasses()">
                        <i class="metismenu-icon" data-lucide="arrow-left"></i> Back to Classes
                    </button>
                </div>
            </div>
        </div>

        <!-- Class Selection View -->
        <div id="classSelectionView">
            <div class="row">
                <?php 
                    $selClasses = $conn->query("SELECT * FROM class_tbl WHERE class_name IN ('JSS 3', 'SS 1', 'SS 2', 'SS 3') ORDER BY class_id ASC");
                    $colors = ['bg-midnight-bloom', 'bg-arielle-smile', 'bg-grow-early', 'bg-premium-dark'];
                    $icons = ['user', 'user-check', 'user-plus', 'graduation-cap'];
                    $i = 0;
                    while($clsRow = $selClasses->fetch(PDO::FETCH_ASSOC)):
                        $clsId = $clsRow['class_id'];
                        $clsName = $clsRow['class_name'];
                        $color = $colors[$i % 4];
                        $icon = $icons[$i % 4];
                        $i++;
                ?>
                <div class="col-md-6 col-xl-3 mb-3">
                    <div class="card widget-content <?php echo $color; ?> p-0" style="position: relative; border-radius: 10px; overflow: hidden; transition: transform 0.3s; min-height: 100px; cursor: pointer;">
                        <div onclick="showForm('<?php echo $clsId; ?>', '<?php echo addslashes($clsName); ?>')" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5;"></div>
                        <div class="widget-content-wrapper text-white p-3">
                            <div class="widget-content-left">
                                <div class="widget-heading" style="font-size: 1.4rem; font-weight: 700;"><?php echo $clsName; ?></div>
                                <div class="widget-subheading opacity-7">Select Student Class</div>
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
        </div>

        <!-- Add Result Form View (Initially Hidden) -->
        <div id="formView" style="display:none;">
            <div class="main-card mb-3 card shadow-sm">
                <div class="card-body">
                    <form id="addResultFrm" method="post" action="query/addResultExe.php">
                        <input type="hidden" name="class_id" id="target_class_id" value="">
                        
                        <h5 class="card-title text-primary">1. Student & Term Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Student Name</label>
                                <select name="exmne_id" id="studentSelect" class="form-control" required>
                                    <option value="">Select Student</option>
                                    <?php 
                                        $selAllExmne = $conn->query("SELECT * FROM examinee_tbl ORDER BY exmne_fullname ASC");
                                        while($row = $selAllExmne->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='".$row['exmne_id']."' class='stu-opt stu-cls-".$row['exmne_class_id']."'>".$row['exmne_fullname']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Term</label>
                                <select name="term" class="form-control" required>
                                    <option value="">Select Term</option>
                                    <option value="1st Term">1st Term</option>
                                    <option value="2nd Term">2nd Term</option>
                                    <option value="3rd Term">3rd Term</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Academic Year</label>
                                <select name="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2025/2026">2025/2026</option>
                                </select>
                            </div>
                        </div>
                        
                        <h5 class="card-title mt-4 text-primary">2. School Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">School Name</label>
                                <input type="text" name="school_name" class="form-control" value="MY LEARNING SECONDARY SCHOOL" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Location</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g., Lagos, Nigeria" required>
                            </div>
                        </div>

                        <h5 class="card-title mt-4 text-primary">3. Remarks & Details</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Attendance</label>
                                <input type="text" name="attendance" class="form-control" placeholder="e.g., 98/100" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Position / Average in Class</label>
                                <input type="text" name="position_or_average" class="form-control" placeholder="e.g., 1st / 85%" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Class Teacher's Name</label>
                                <input type="text" name="teachers_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Performance Remark</label>
                                <input type="text" name="performance_remark" class="form-control" placeholder="e.g., An excellent performance. Keep it up!" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Attitude Remark</label>
                                <input type="text" name="attitude_remark" class="form-control" placeholder="e.g., Very attentive and well-behaved." required>
                            </div>
                        </div>

                        <h5 class="card-title mt-4 text-primary">4. Subject Scores</h5>
                        <hr>
                        <p class="text-muted small">Enter scores for subjects. Leave blank if not applicable.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Subject</th>
                                        <th width="25%">C.A Score (Max 40)</th>
                                        <th width="25%">Exam Score (Max 60)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $selSubj = $conn->query("SELECT * FROM course_tbl ORDER BY cou_name ASC");
                                        while($subj = $selSubj->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td class="align-middle"><strong><?php echo $subj['cou_name']; ?></strong>
                                            <input type="hidden" name="subject_ids[]" value="<?php echo $subj['cou_id']; ?>">
                                        </td>
                                        <td><input type="number" step="0.01" max="40" name="ca_scores[]" class="form-control" placeholder="C.A"></td>
                                        <td><input type="number" step="0.01" max="60" name="exam_scores[]" class="form-control" placeholder="Exam"></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i data-lucide="save" style="width:18px;height:18px;display:inline-block;vertical-align:middle;margin-right:8px;"></i> Save Result
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle between class cards and the form view
    function showForm(classId, className) {
        // Update UI
        $('#classSelectionView').fadeOut(200, function() {
            $('#formView').fadeIn(300);
            $('#backToClassesBtn').show();
            $('#pageTitleText').text('ADD RESULT - ' + className.toUpperCase());
            $('#target_class_id').val(classId);
            
            // Filter student dropdown
            $('#studentSelect option').hide();
            $('#studentSelect option[value=""]').show();
            $('.stu-cls-' + classId).show();
            $('#studentSelect').val('');
        });
    }

    function showClasses() {
        $('#formView').fadeOut(200, function() {
            $('#classSelectionView').fadeIn(300);
            $('#backToClassesBtn').hide();
            $('#pageTitleText').text('ADD STUDENT RESULT');
            $('#addResultFrm')[0].reset();
        });
    }

    $(document).ready(function() {
        if(typeof lucide !== 'undefined') lucide.createIcons();

        // Handle Form Submission via AJAX
        $('#addResultFrm').on('submit', function(e) {
            e.preventDefault();
            
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    btn.prop('disabled', false).html('<i data-lucide="save" style="width:18px;height:18px;display:inline-block;vertical-align:middle;margin-right:8px;"></i> Save Result');
                    lucide.createIcons();

                    if(data.res == "success") {
                        Swal.fire({
                            title: 'Result Saved!',
                            text: 'The student result has been successfully recorded.',
                            icon: 'success'
                        }).then(() => {
                            showClasses(); // Return to class selection
                        });
                    } else if(data.res == "exist") {
                        Swal.fire('Duplicate Result', 'A result for this student, term, and year already exists.', 'error');
                    } else {
                        Swal.fire('Error', 'Failed to save result. Please try again.', 'error');
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i data-lucide="save" style="width:18px;height:18px;display:inline-block;vertical-align:middle;margin-right:8px;"></i> Save Result');
                    lucide.createIcons();
                    Swal.fire('System Error', 'Could not connect to the server.', 'error');
                }
            });
        });
    });
</script>
