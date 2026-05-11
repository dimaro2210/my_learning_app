
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-bookmarks icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Manage Courses
                        <div class="page-title-subheading">View and manage available courses in the system.</div>
                    </div>
                </div>
            </div>
        </div>        
        
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-book icon-gradient bg-tempting-azure"></i>
                    Course List
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-left pl-4">Course Name</th>
                            <th class="text-center" width="20%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $selCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC ");
                            if($selCourse->rowCount() > 0)
                            {
                                $num = 1;
                                while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td class="text-center text-muted"><?php echo $num++; ?></td>
                                        <td class="pl-4" style="font-weight: 500;">
                                            <?php echo $selCourseRow['cou_name']; ?>
                                        </td>
                                        <td class="text-center">
                                         <button type="button" data-toggle="modal" data-target="#updateCourse-<?php echo $selCourseRow['cou_id']; ?>" class="btn btn-primary btn-sm">
                                             <i class="fa fa-pencil"></i> Update
                                         </button>
                                         <button type="button" id="deleteCourse" data-id='<?php echo $selCourseRow['cou_id']; ?>' class="btn btn-danger btn-sm">
                                             <i class="fa fa-trash"></i> Delete
                                         </button>
                                        </td>
                                    </tr>

                                <?php }
                            }
                            else
                            { ?>
                                <tr>
                                  <td colspan="3" class="text-center p-4">
                                    <i class="pe-7s-info" style="font-size: 36px; color: #9ca3af;"></i>
                                    <h5 class="mt-2 text-muted">No courses found</h5>
                                  </td>
                                </tr>
                            <?php }
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
    </div>
</div>
