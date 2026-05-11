<!-- Modal For Add Course -->
<div class="modal fade" id="modalForAddCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addCourseFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Course</label>
            <input type="" name="course_name" id="course_name" class="form-control" placeholder="Input Course" required="" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
  </div>
</div>



<!-- Modal For Add Exam -->
<div class="modal fade" id="modalForExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form id="addExamFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Select Subject</label>
            <select class="form-control" name="cou_id" required>
              <option value="">Select Subject</option>
              <?php 
                $selCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id DESC");
                if($selCourse->rowCount() > 0)
                {
                  while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                     <option value="<?php echo $selCourseRow['cou_id']; ?>"><?php echo $selCourseRow['cou_name']; ?></option>
                  <?php }
                }
                else
                { ?>
                  <option value="">No Subjects Found</option>
                <?php }
               ?>
            </select>
          </div>

          <div class="form-group">
            <label>Select Class</label>
            <select class="form-control" name="ex_class_id" onchange="toggleDept(this, 'exam_dept_group')" required>
              <option value="">Select Class</option>
              <?php 
                $selClass = $conn->query("SELECT * FROM class_tbl ORDER BY class_id asc");
                while ($selClassRow = $selClass->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $selClassRow['class_id']; ?>"><?php echo $selClassRow['class_name']; ?></option>
                <?php }
               ?>
            </select>
          </div>

          <div class="form-group" id="exam_dept_group" style="display:none;">
            <label>Select Department</label>
            <select class="form-control" name="deptSelected">
              <option value="0">Select Department</option>
              <?php 
                $selDept = $conn->query("SELECT * FROM department_tbl ORDER BY dept_id asc");
                while ($selDeptRow = $selDept->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $selDeptRow['dept_id']; ?>"><?php echo $selDeptRow['dept_name']; ?></option>
                <?php }
               ?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Term</label>
                <select class="form-control" name="term" required>
                  <option value="">Select Term</option>
                  <option value="1st Term">1st Term</option>
                  <option value="2nd Term">2nd Term</option>
                  <option value="3rd Term">3rd Term</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Academic Year</label>
                <select class="form-control" name="year" required>
                  <option value="">Select Year</option>
                  <?php
                    $currentYear = (int)date('Y');
                    for ($y = 2023; $y <= $currentYear + 1; $y++) {
                        echo "<option value='$y/" . ($y+1) . "'>$y/" . ($y+1) . "</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Exam Title</label>
            <input type="text" name="ex_title" class="form-control" placeholder="e.g. First Term Mathematics Exam" required>
          </div>

          <div class="form-group">
            <label>Exam Description</label>
            <textarea name="ex_description" class="form-control" rows="3" placeholder="e.g. Do not use calculators."></textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Time Limit (minutes)</label>
                <select class="form-control" name="ex_time_limit" required>
                  <option value="">Select time</option>
                  <option value="10">10 Minutes</option>
                  <option value="20">20 Minutes</option>
                  <option value="30">30 Minutes</option>
                  <option value="40">40 Minutes</option>
                  <option value="50">50 Minutes</option>
                  <option value="60">60 Minutes</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Question Display Limit</label>
                <input type="number" name="ex_questlimit_display" class="form-control" placeholder="e.g. 30" required>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Exam</button>
      </div>
    </div>
   </form>
  </div>
</div>


<!-- Modal For Add Examinee -->
<div class="modal fade" id="modalForAddExaminee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addExamineeFrm" method="post">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Examinee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Fullname</label>
            <input type="" name="fullname" id="fullname" class="form-control" placeholder="Input Fullname" autocomplete="off" required="">
          </div>
          <div class="form-group">
            <label>Birhdate</label>
            <input type="date" name="bdate" id="bdate" class="form-control" placeholder="Input Birhdate" autocomplete="off" >
          </div>
          <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender" id="gender">
              <option value="0">Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label>Course</label>
            <select class="form-control" name="course" id="course">
              <option value="0">Select course</option>
              <?php 
                $selCourse = $conn->query("SELECT * FROM course_tbl ORDER BY cou_id asc");
                while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $selCourseRow['cou_id']; ?>"><?php echo $selCourseRow['cou_name']; ?></option>
                <?php }
               ?>
            </select>
          </div>
          <div class="form-group">
            <label>Class</label>
            <select class="form-control" name="class_id" id="class_id" onchange="toggleDept(this, 'dept_group')">
              <option value="0">Select Class</option>
              <?php 
                $selClass = $conn->query("SELECT * FROM class_tbl ORDER BY class_id asc");
                while ($selClassRow = $selClass->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $selClassRow['class_id']; ?>"><?php echo $selClassRow['class_name']; ?></option>
                <?php }
               ?>
            </select>
          </div>
          <div class="form-group" id="dept_group" style="display:none;">
            <label>Department</label>
            <select class="form-control" name="dept_id" id="dept_id">
              <option value="0">Select Department</option>
              <?php 
                $selDept = $conn->query("SELECT * FROM department_tbl ORDER BY dept_id asc");
                while ($selDeptRow = $selDept->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $selDeptRow['dept_id']; ?>"><?php echo $selDeptRow['dept_name']; ?></option>
                <?php }
               ?>
            </select>
          </div>
          <!-- Email and Password are now automated based on fullname -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
    </div>
   </form>
  </div>
</div>



<?php if (isset($selExamRow) && is_array($selExamRow)) { ?>
<!-- Modal For Add Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question for <br><?php echo $selExamRow['ex_title']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addQuestionFrm" method="post">
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Question</label>
            <input type="hidden" name="examId" value="<?php echo $exId; ?>">
            <input type="text" name="question" class="form-control" placeholder="Input question" autocomplete="off">
          </div>

          <fieldset>
            <legend>Input choices</legend>
            <div class="form-group">
                <label>Choice A</label>
                <input type="text" name="choice_A" id="choice_A" class="form-control" placeholder="Input choice A" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Choice B</label>
                <input type="text" name="choice_B" id="choice_B" class="form-control" placeholder="Input choice B" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Choice C</label>
                <input type="text" name="choice_C" id="choice_C" class="form-control" placeholder="Input choice C" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Choice D</label>
                <input type="text" name="choice_D" id="choice_D" class="form-control" placeholder="Input choice D" autocomplete="off">
            </div>
            <div class="form-group">
                <label>Correct Answer</label>
                <input type="text" name="correctAnswer" class="form-control" placeholder="Must match one of the choices above" autocomplete="off">
            </div>
          </fieldset>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>

<script>
function toggleDept(selectObj, deptGroupId) {
    var selectedText = selectObj.options[selectObj.selectedIndex].text;
    if (selectedText.includes("SS")) {
        document.getElementById(deptGroupId).style.display = "block";
    } else {
        document.getElementById(deptGroupId).style.display = "none";
        document.getElementById(deptGroupId).querySelector('select').value = "0";
    }
}
</script>