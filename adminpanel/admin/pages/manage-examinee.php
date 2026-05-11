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
                                echo "MANAGE STUDENTS - " . ($selClass ? strtoupper($selClass['class_name']) : 'UNKNOWN');
                            } else {
                                echo "MANAGE STUDENTS";
                            }
                        ?>
                    </div>
                </div>
                <div class="page-title-actions">
                    <?php if($class_id): ?>
                    <button type="button" class="btn btn-sm btn-primary mr-2" onclick="toggleAddForm()">
                        <i class="metismenu-icon" data-lucide="user-plus"></i> Add Student
                    </button>
                    <a href="home.php?page=manage-examinee" class="btn btn-sm btn-outline-primary">
                        <i class="metismenu-icon" data-lucide="arrow-left"></i> Back to Classes
                    </a>
                    <?php else: ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForAddExaminee">
                        <i class="metismenu-icon" data-lucide="user-plus"></i> Add Student
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(!$class_id): ?>
        <!-- Class Selection Cards -->
        <div class="row" id="classCardsRow">
            <?php 
                $selClasses = $conn->query("SELECT * FROM class_tbl WHERE class_name IN ('JSS 3', 'SS 1', 'SS 2', 'SS 3') ORDER BY class_id ASC");
                $colors = ['bg-midnight-bloom', 'bg-arielle-smile', 'bg-grow-early', 'bg-premium-dark'];
                $icons = ['users', 'user-check', 'user-plus', 'graduation-cap'];
                $i = 0;
                while($clsRow = $selClasses->fetch(PDO::FETCH_ASSOC)):
                    $clsId = $clsRow['class_id'];
                    $clsName = $clsRow['class_name'];
                    $color = $colors[$i % 4];
                    $icon = $icons[$i % 4];
                    $i++;
                    $count = $conn->query("SELECT count(exmne_id) as total FROM examinee_tbl WHERE exmne_class_id='$clsId'")->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-md-6 col-xl-3 mb-3">
                <div class="card widget-content <?php echo $color; ?> p-0" style="position: relative; border-radius: 10px; overflow: hidden; transition: transform 0.3s; min-height: 100px;">
                    <a href="home.php?page=manage-examinee&class_id=<?php echo $clsId; ?>" style="text-decoration: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5; display: block;"></a>
                    <div class="widget-content-wrapper text-white p-3">
                        <div class="widget-content-left">
                            <div class="widget-heading" style="font-size: 1.4rem; font-weight: 700;"><?php echo $clsName; ?></div>
                            <div class="widget-subheading opacity-7">Total Students: <?php echo $count['total']; ?></div>
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
        <!-- Add Student Collapsible Form -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header" style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;" onclick="toggleAddForm()">
                    <span><i data-lucide="user-plus" style="width:18px;height:18px;display:inline;vertical-align:middle;"></i> <strong>Add New Student to <?php echo $selClass['class_name']; ?></strong></span>
                    <i data-lucide="chevron-down" id="addFormToggleIcon" style="width:18px;height:18px;transition:transform 0.3s;"></i>
                </div>
                <div id="addStudentForm" style="display:none;">
                    <div class="card-body">
                        <form method="post" id="addExamineeFrm">
                            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Fullname</strong></label>
                                        <input type="text" name="fullname" class="form-control" placeholder="e.g. John Doe" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Gender</strong></label>
                                        <select class="form-control" name="gender" required>
                                            <option value="0">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Birthdate</strong></label>
                                        <input type="date" name="bdate" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Course</strong></label>
                                        <select class="form-control" name="course" required>
                                            <option value="0">Select Course</option>
                                            <?php 
                                                $selCourses = $conn->query("SELECT * FROM course_tbl ORDER BY cou_name ASC");
                                                while($cRow = $selCourses->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $cRow['cou_id']; ?>"><?php echo $cRow['cou_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if(strpos($selClass['class_name'], 'SS') !== false): ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Department</strong></label>
                                        <select class="form-control" name="dept_id">
                                            <option value="0">Select Department</option>
                                            <?php 
                                                $selDepts = $conn->query("SELECT * FROM department_tbl ORDER BY dept_name ASC");
                                                while($dRow = $selDepts->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $dRow['dept_id']; ?>"><?php echo $dRow['dept_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php else: ?>
                                <input type="hidden" name="dept_id" value="0">
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary"><i data-lucide="plus" style="width:16px;height:16px;display:inline;vertical-align:middle;"></i> Add Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table for Selected Class -->
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Student List - <?php echo $selClass['class_name']; ?></div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Gender</th>
                                <th>Dept</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $selExmne = $conn->query("SELECT e.*, d.dept_name FROM examinee_tbl e LEFT JOIN department_tbl d ON e.exmne_dept_id = d.dept_id WHERE e.exmne_class_id = '$class_id' ORDER BY e.exmne_fullname ASC");
                                if($selExmne->rowCount() > 0) {
                                    while ($selExmneRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { 
                            ?>
                            <tr>
                                <td><div class="font-weight-bold"><?php echo strtoupper($selExmneRow['exmne_fullname']); ?></div></td>
                                <td><code style="color: var(--primary); font-weight: 600;"><?php echo $selExmneRow['exmne_email']; ?></code></td>
                                <td><code style="color: var(--text-muted);">BOU26</code></td>
                                <td><?php echo $selExmneRow['exmne_gender']; ?></td>
                                <td><?php echo $selExmneRow['dept_name'] ?: 'N/A'; ?></td>
                                <td>
                                    <?php if($selExmneRow['exmne_status'] == 'active'): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a rel="facebox" href="facebox_modal/updateExaminee.php?id=<?php echo $selExmneRow['exmne_id']; ?>" class="btn btn-sm btn-primary">Update</a>
                                </td>
                            </tr>
                            <?php }
                                } else { ?>
                            <tr>
                                <td colspan="7" class="text-center p-5">
                                    <div class="text-muted">No students found in this class.</div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Toggle the collapsible add-student form in the class detail view
    function toggleAddForm() {
        var form = document.getElementById('addStudentForm');
        var icon = document.getElementById('addFormToggleIcon');
        if (form.style.display === 'none') {
            form.style.display = 'block';
            icon.style.transform = 'rotate(180deg)';
        } else {
            form.style.display = 'none';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Open the global add-student modal from a class card and pre-select the class
    function openAddStudentFromCard(classId) {
        var $modal = $('#modalForAddExaminee');
        var $classSelect = $modal.find('select[name="class_id"]');
        
        // Pre-select the class
        $classSelect.val(classId).trigger('change');
        
        // Show the modal
        $modal.modal('show');
    }

    // Re-initialize icons for dynamic content
    if(typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
