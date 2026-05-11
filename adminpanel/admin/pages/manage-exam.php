<style>
    .dropdown-item { color: #333 !important; font-weight: 500; }
    .dropdown-item:hover { background-color: #f8f9fa; }
    .dropdown-item.active { background-color: var(--primary) !important; color: #fff !important; }
    /* Dark mode overrides if needed */
    .dark-mode .dropdown-menu { background-color: #2c3e50; border-color: #34495e; }
    .dark-mode .dropdown-item { color: #ecf0f1 !important; }
    .dark-mode .dropdown-item:hover { background-color: #3e5871; }
</style>
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
                        <div class="page-title-subheading">Control exam availability and track student participation.</div>
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
                                <th>Status</th>
                                <th class="text-center">Control</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $selExam = $conn->query("SELECT e.*, c.cou_name FROM exam_tbl e INNER JOIN course_tbl c ON e.cou_id = c.cou_id WHERE e.ex_class_id = '$class_id' ORDER BY e.ex_id DESC");
                                if($selExam->rowCount() > 0) {
                                    while ($selExamRow = $selExam->fetch(PDO::FETCH_ASSOC)) { 
                                        $exId = $selExamRow['ex_id'];
                                        $status = $selExamRow['ex_status'] ?: 'stopped';
                                        
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
                                <td>
                                    <?php 
                                        if($status == 'started') echo '<span class="badge badge-success">RUNNING</span>';
                                        elseif($status == 'paused') echo '<span class="badge badge-warning">PAUSED</span>';
                                        else echo '<span class="badge badge-danger">STOPPED</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="btn-icon btn-icon-only btn btn-outline-primary btn-sm">
                                            <i data-lucide="more-vertical" style="width:16px;"></i>
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="min-width: 120px;">
                                            <h6 tabindex="-1" class="dropdown-header">Exam Status</h6>
                                            <button type="button" tabindex="0" class="dropdown-item btn-status <?php echo $status == 'started' ? 'active' : ''; ?>" data-id="<?php echo $exId; ?>" data-status="started">
                                                <i data-lucide="play" class="mr-2" style="width:14px;color:#28a745;"></i> Start
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item btn-status <?php echo $status == 'paused' ? 'active' : ''; ?>" data-id="<?php echo $exId; ?>" data-status="paused">
                                                <i data-lucide="pause" class="mr-2" style="width:14px;color:#ffc107;"></i> Pause
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item btn-status <?php echo $status == 'stopped' ? 'active' : ''; ?>" data-id="<?php echo $exId; ?>" data-status="stopped">
                                                <i data-lucide="square" class="mr-2" style="width:14px;color:#dc3545;"></i> Stop
                                            </button>
                                        </div>
                                    </div>
                                </td>
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
                                <td colspan="6" class="text-center p-5">
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
        // Status Update
        $('.btn-status').click(function(){
            var id = $(this).data('id');
            var status = $(this).data('status');
            $.ajax({
                type: "POST",
                url: "query/updateExamStatus.php",
                data: {id:id, status:status},
                dataType: "json",
                success: function(data){
                    if(data.res == "success"){
                        // Update badge in real-time
                        var badge = $('button[data-id="'+id+'"]').closest('tr').find('td .badge');
                        if(status == 'started') badge.attr('class', 'badge badge-success').text('RUNNING');
                        else if(status == 'paused') badge.attr('class', 'badge badge-warning').text('PAUSED');
                        else badge.attr('class', 'badge badge-danger').text('STOPPED');
                        
                        // Show toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Status updated to ' + status
                        });
                    }
                }
            });
        });

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
