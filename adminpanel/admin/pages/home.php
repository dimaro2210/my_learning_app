

<div class="app-main__outer">
    <div id="refreshData">
    <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-rocket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>Admin Dashboard
                            <div class="page-title-subheading">Welcome back! Here's an overview of your learning platform.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card mb-3 widget-content bg-midnight-bloom" style="border-radius: 20px!important; padding: 25px 20px!important;">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Subjects</div>
                                <div class="widget-subheading">Active subjects</div>
                            </div>
                            <div class="widget-content-right" style="text-align: right;">
                                <i class="fa fa-book" style="font-size:24px; opacity:0.8; display:block; margin-bottom: 5px;"></i>
                                <div class="widget-numbers text-white">
                                    <span><?php echo $selCourse['totCourse']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card mb-3 widget-content bg-arielle-smile" style="border-radius: 20px!important; padding: 25px 20px!important;">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Exams</div>
                                <div class="widget-subheading">All exams created</div>
                            </div>
                            <div class="widget-content-right" style="text-align: right;">
                                <i class="fa fa-file-text" style="font-size:24px; opacity:0.8; display:block; margin-bottom: 5px;"></i>
                                <div class="widget-numbers text-white">
                                    <span><?php echo $selExam['totExam']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card mb-3 widget-content bg-grow-early" style="border-radius: 20px!important; padding: 25px 20px!important;">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Students</div>
                                <div class="widget-subheading">Registered students</div>
                            </div>
                            <div class="widget-content-right" style="text-align: right;">
                                <i class="fa fa-users" style="font-size:24px; opacity:0.8; display:block; margin-bottom: 5px;"></i>
                                <div class="widget-numbers text-white">
                                    <span><?php echo $selStudent['totStudent']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card mb-3 widget-content bg-mean-fruit" style="border-radius: 20px!important; padding: 25px 20px!important;">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Feedbacks</div>
                                <div class="widget-subheading">Student feedbacks</div>
                            </div>
                            <div class="widget-content-right" style="text-align: right;">
                                <i class="fa fa-comments" style="font-size:24px; opacity:0.8; display:block; margin-bottom: 5px;"></i>
                                <div class="widget-numbers text-white">
                                    <span><?php echo $selFeedback['totFeedback']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Data -->
            <div class="row">
                <!-- Recent Students -->
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="fa fa-users" style="margin-right:8px;color:var(--primary);"></i>
                            Recent Students
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-center">Course</th>
                                        <th class="text-center">Level</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $selRecentStudents = $conn->query("SELECT e.*, c.cou_name FROM examinee_tbl e LEFT JOIN course_tbl c ON e.exmne_course = c.cou_id ORDER BY e.exmne_id DESC LIMIT 5");
                                    if($selRecentStudents->rowCount() > 0) {
                                        while($stuRow = $selRecentStudents->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><b><?php echo $stuRow['exmne_fullname']; ?></b>
                                            <div class="text-muted" style="font-size:11px;"><?php echo $stuRow['exmne_email']; ?></div>
                                        </td>
                                        <td class="text-center"><span class="badge badge-primary"><?php echo $stuRow['cou_name'] ?? 'N/A'; ?></span></td>
                                        <td class="text-center"><?php echo ucfirst($stuRow['exmne_year_level']); ?></td>
                                        <td class="text-center"><span class="badge badge-success"><?php echo ucfirst($stuRow['exmne_status']); ?></span></td>
                                    </tr>
                                <?php } } else { ?>
                                    <tr><td colspan="4" class="text-center p-3 text-muted">No students registered yet.</td></tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-block text-center card-footer">
                            <a href="home.php?page=manage-examinee" class="btn btn-sm btn-primary">View All Students</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Feedbacks -->
                <div class="col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="fa fa-comments-o" style="margin-right:8px;color:var(--primary);"></i>
                            Recent Feedbacks
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>Feedback</th>
                                        <th class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $selRecentFb = $conn->query("SELECT * FROM feedbacks_tbl ORDER BY fb_id DESC LIMIT 5");
                                    if($selRecentFb->rowCount() > 0) {
                                        while($fbRow = $selRecentFb->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><b><?php echo ($fbRow['fb_exmne_as'] != '') ? $fbRow['fb_exmne_as'] : 'Anonymous'; ?></b></td>
                                        <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo $fbRow['fb_feedbacks']; ?></td>
                                        <td class="text-center"><span style="font-size:11px;color:var(--text-muted);"><?php echo $fbRow['fb_date']; ?></span></td>
                                    </tr>
                                <?php } } else { ?>
                                    <tr><td colspan="3" class="text-center p-3 text-muted">No feedbacks yet.</td></tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-block text-center card-footer">
                            <a href="home.php?page=feedbacks" class="btn btn-sm btn-primary">View All Feedbacks</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <i class="fa fa-bolt" style="margin-right:8px;color:var(--warning);"></i>
                            Quick Actions
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-3 mb-3">
                                    <a href="#" data-toggle="modal" data-target="#modalForAddCourse" class="btn btn-outline-primary btn-block" style="padding:20px 10px!important;border-radius:12px!important;">
                                        <i class="fa fa-plus-circle" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        <span style="font-size:12px;">Add Course</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <a href="#" data-toggle="modal" data-target="#modalForExam" class="btn btn-outline-primary btn-block" style="padding:20px 10px!important;border-radius:12px!important;">
                                        <i class="fa fa-plus-square" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        <span style="font-size:12px;">Add Exam</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <a href="#" data-toggle="modal" data-target="#modalForAddExaminee" class="btn btn-outline-primary btn-block" style="padding:20px 10px!important;border-radius:12px!important;">
                                        <i class="fa fa-user-plus" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        <span style="font-size:12px;">Add Student</span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <a href="home.php?page=ranking-exam" class="btn btn-outline-primary btn-block" style="padding:20px 10px!important;border-radius:12px!important;">
                                        <i class="fa fa-trophy" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        <span style="font-size:12px;">Rankings</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      
        </div>
         
    </div>
