
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon" data-lucide="clipboard-list" style="color:var(--primary);"></i>
                    </div>
                    <div>
                        <?php 
                            $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
                            if($class_id) {
                                $selClass = $conn->query("SELECT * FROM class_tbl WHERE class_id='$class_id'")->fetch(PDO::FETCH_ASSOC);
                                echo "MANAGE EXAMS - " . ($selClass ? strtoupper($selClass['class_name']) : 'UNKNOWN');
                            } else {
                                echo "MANAGE EXAMS";
                            }
                        ?>
                        <div class="page-title-subheading">Manage exam details and track student participation.</div>
                    </div>
                </div>
                <?php if($class_id): ?>
                <div class="page-title-actions">
                    <a href="home.php?page=manage-exam" class="btn btn-sm btn-outline-primary">
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
                $classes = [
                    ['id' => 1, 'name' => 'JSS 3', 'icon' => 'users', 'color' => 'bg-midnight-bloom'],
                    ['id' => 2, 'name' => 'SS 1', 'icon' => 'user-check', 'color' => 'bg-arielle-smile'],
                    ['id' => 3, 'name' => 'SS 2', 'icon' => 'user-plus', 'color' => 'bg-grow-early'],
                    ['id' => 4, 'name' => 'SS 3', 'icon' => 'graduation-cap', 'color' => 'bg-premium-dark'],
                ];
                foreach($classes as $cls):
                    $count = $conn->query("SELECT count(ex_id) as total FROM exam_tbl WHERE ex_class_id='{$cls['id']}'")->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-md-6 col-xl-3">
                <a href="home.php?page=manage-exam&class_id=<?php echo $cls['id']; ?>" style="text-decoration: none;">
                    <div class="card mb-3 widget-content <?php echo $cls['color']; ?> text-white">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading" style="font-size: 1.4rem; font-weight: 700;"><?php echo $cls['name']; ?></div>
                                <div class="widget-subheading">Total Exams: <?php echo $count['total']; ?></div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white" style="opacity: 0.5;">
                                    <i data-lucide="<?php echo $cls['icon']; ?>" style="width: 32px; height: 32px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Exams Table for Selected Class -->
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Exam List - <?php echo $selClass['class_name']; ?></div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th>Exam Title</th>
                                <th>Subject</th>
                                <th>Questions</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $selExam = $conn->query("SELECT e.*, c.cou_name FROM exam_tbl e INNER JOIN course_tbl c ON e.cou_id = c.cou_id WHERE e.ex_class_id = '$class_id' ORDER BY e.ex_id DESC");
                                if($selExam->rowCount() > 0) {
                                    while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { 
                                        $exId = $selExamRow['ex_id'];
                                        
                                        // Count attempts
                                        $attCount = $conn->query("SELECT COUNT(*) as cnt FROM exam_attempt WHERE exam_id='$exId'")->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold"><?php echo strtoupper($selExamRow['ex_title']); ?></div>
                                    <div class="text-muted small"><?php echo $selExamRow['ex_description']; ?></div>
                                </td>
                                <td><?php echo $selExamRow['cou_name']; ?></td>
                                <td><?php echo $selExamRow['ex_questlimit_display']; ?></td>

                                <td class="text-center">
                                    <a href="home.php?page=exam-attendance&id=<?php echo $exId; ?>" class="btn btn-sm btn-info" title="Attendance">
                                        <i data-lucide="users" style="width:14px;"></i> (<?php echo $attCount['cnt']; ?>)
                                    </a>
                                    <a href="manage-exam.php?id=<?php echo $exId; ?>" class="btn btn-sm btn-primary" title="Manage Questions">
                                        <i data-lucide="edit-3" style="width:14px;"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete-exam" data-id="<?php echo $exId; ?>" title="Delete">
                                        <i data-lucide="trash-2" style="width:14px;"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php }
                                } else { ?>
                            <tr>
                                <td colspan="4" class="text-center p-5">
                                    <div class="text-muted">No exams found for this class. <a href="home.php?page=add-exam">Create one now?</a></div>
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
    $(document).ready(function(){


        // Delete Exam
        $('.btn-delete-exam').click(function(){
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete all questions and results for this exam!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "query/deleteExamExe.php",
                        data: {id:id},
                        dataType: "json",
                        success: function(data){
                            if(data.res == "success"){
                                Swal.fire('Deleted!', 'Exam has been deleted.', 'success');
                                $('button[data-id="'+id+'"]').closest('tr').fadeOut(400, function(){
                                    $(this).remove();
                                });
                            }
                        }
                    });
                }
            });
        });

        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
