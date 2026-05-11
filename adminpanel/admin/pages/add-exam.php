<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon" data-lucide="file-plus" style="color:var(--primary);"></i>
                    </div>
                    <div>ADD NEW EXAM
                        <div class="page-title-subheading">Select a class first to start creating an examination.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 1: Card Dashboard -->
        <div id="step1" class="row">
            <?php 
                $classes = [
                    ['id' => 1, 'name' => 'JSS 3', 'icon' => 'users', 'color' => 'bg-midnight-bloom'],
                    ['id' => 2, 'name' => 'SS 1', 'icon' => 'user-check', 'color' => 'bg-arielle-smile'],
                    ['id' => 3, 'name' => 'SS 2', 'icon' => 'user-plus', 'color' => 'bg-grow-early'],
                    ['id' => 4, 'name' => 'SS 3', 'icon' => 'graduation-cap', 'color' => 'bg-premium-dark'],
                ];
                foreach($classes as $cls):
            ?>
            <div class="col-md-6 col-xl-3">
                <div class="card mb-3 widget-content <?php echo $cls['color']; ?> text-white class-card" 
                     style="cursor:pointer;" 
                     onclick="selectClass(<?php echo $cls['id']; ?>, '<?php echo $cls['name']; ?>')">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading" style="font-size: 1.4rem; font-weight: 700;"><?php echo $cls['name']; ?></div>
                            <div class="widget-subheading">Select this class</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white" style="opacity: 0.5;">
                                <i data-lucide="<?php echo $cls['icon']; ?>" style="width: 32px; height: 32px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Step 2: Form -->
        <div id="step2" style="display:none;">
            <div style="margin-bottom:20px;">
                <button type="button" class="btn btn-outline-primary btn-sm" id="backToStep1" style="display:inline-flex;align-items:center;gap:6px;">
                    <i data-lucide="arrow-left" style="width:14px;"></i> Back to Classes
                </button>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-header">Create Exam for <span id="selectedClassName" class="text-primary ml-1"></span></div>
                <div class="card-body">
                    <form id="addExamForm" method="post" action="query/addExamExe.php" onsubmit="return addExam(this);">
                        <input type="hidden" name="ex_class_id" id="hiddenClassId">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Term</label>
                                <select name="term" class="form-control" required>
                                    <option value="">Select Term</option>
                                    <option value="1st Term">1st Term</option>
                                    <option value="2nd Term">2nd Term</option>
                                    <option value="3rd Term">3rd Term</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Academic Year</label>
                                <select name="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    <?php
                                        $cy = (int)date('Y');
                                        for ($y = 2023; $y <= $cy + 1; $y++) {
                                            echo "<option value='$y/".($y+1)."'>$y/".($y+1)."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Subject</label>
                                <select name="cou_id" class="form-control" required>
                                    <option value="">Select Subject</option>
                                    <?php 
                                        $selSubj = $conn->query("SELECT * FROM course_tbl ORDER BY cou_name ASC");
                                        while($subj = $selSubj->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='".$subj['cou_id']."'>".$subj['cou_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <label>Exam Title</label>
                                <input type="text" name="ex_title" class="form-control" placeholder="e.g. First Term Mathematics Exam" required>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Special Information / Description</label>
                                <textarea name="ex_description" class="form-control" rows="2" placeholder="e.g. Do not use calculators."></textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Time Limit (in minutes)</label>
                                <input type="number" name="ex_time_limit" class="form-control" required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Question Display Limit</label>
                                <input type="number" name="ex_questlimit_display" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group text-right mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">Add Exam & Proceed to Questions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectClass(id, name) {
        document.getElementById('hiddenClassId').value = id;
        document.getElementById('selectedClassName').innerText = name;
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
    }

    function addExam(form) {
        $.ajax({
            type: "POST",
            url: $(form).attr('action'),
            data: $(form).serialize(),
            dataType: "json",
            success: function(data) {
                if(data.res == "success") {
                    Swal.fire({
                        title: 'Exam Created!',
                        text: 'Now you will be redirected to add questions.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'manage-exam.php?id=' + data.ex_id;
                    });
                } else if(data.res == "exist") {
                    Swal.fire({
                        title: 'Already Exists',
                        text: 'An exam with this title already exists for this class, term, and year.',
                        icon: 'warning'
                    });
                } else {
                    Swal.fire('Error', 'Failed to create exam. Please check all fields.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Network error or server-side failure.', 'error');
            }
        });
        return false; // Prevent standard submission
    }

    $(document).ready(function() {
        $('#backToStep1').click(function() {
            $('#step2').hide();
            $('#step1').fadeIn();
        });
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>

