
<?php 
  include("../../../conn.php");
  $id = $_GET['id'];
 
  $selExmne = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$id' ")->fetch(PDO::FETCH_ASSOC);

 ?>

<fieldset style="width:543px;" >
	<legend><i class="facebox-header"><i class="edit large icon"></i>&nbsp;Update <b>( <?php echo strtoupper($selExmne['exmne_fullname']); ?> )</b></i></legend>
  <div class="col-md-12 mt-4">
<form method="post" id="updateExamineeFrm">
     <div class="form-group">
        <legend>Fullname</legend>
        <input type="hidden" name="exmne_id" value="<?php echo $id; ?>">
        <input type="" name="exFullname" class="form-control" required="" value="<?php echo $selExmne['exmne_fullname']; ?>" >
     </div>

     <div class="form-group">
        <legend>Gender</legend>
        <select class="form-control" name="exGender">
          <option value="<?php echo $selExmne['exmne_gender']; ?>"><?php echo $selExmne['exmne_gender']; ?></option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
     </div>

     <div class="form-group">
        <legend>Birthdate</legend>
        <input type="date" name="exBdate" class="form-control" required="" value="<?php echo date('Y-m-d',strtotime($selExmne["exmne_birthdate"])) ?>"/>
     </div>

     <div class="form-group">
        <legend>Course</legend>
        <?php 
            $exmneCourse = $selExmne['exmne_course'];
            $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id='$exmneCourse' ")->fetch(PDO::FETCH_ASSOC);
         ?>
         <select class="form-control" name="exCourse">
           <option value="<?php echo $exmneCourse; ?>"><?php echo $selCourse['cou_name']; ?></option>
           <?php 
             $selCourse = $conn->query("SELECT * FROM course_tbl WHERE cou_id!='$exmneCourse' ");
             while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
              <option value="<?php echo $selCourseRow['cou_id']; ?>"><?php echo $selCourseRow['cou_name']; ?></option>
            <?php  }
            ?>
         </select>
     </div>

     <div class="form-group">
        <legend>Class</legend>
        <?php 
            $exmneClassId = isset($selExmne['exmne_class_id']) ? $selExmne['exmne_class_id'] : 0;
            $selClass = $conn->query("SELECT * FROM class_tbl WHERE class_id='$exmneClassId' ")->fetch(PDO::FETCH_ASSOC);
         ?>
         <select class="form-control" name="exClassId" onchange="toggleDeptUpdate(this)">
           <option value="<?php echo $exmneClassId; ?>"><?php echo $selClass ? $selClass['class_name'] : 'Select Class'; ?></option>
           <?php 
             $selClasses = $conn->query("SELECT * FROM class_tbl WHERE class_id!='$exmneClassId' ");
             while ($selClassRow = $selClasses->fetch(PDO::FETCH_ASSOC)) { ?>
              <option value="<?php echo $selClassRow['class_id']; ?>"><?php echo $selClassRow['class_name']; ?></option>
            <?php  }
            ?>
         </select>
     </div>

     <div class="form-group" id="update_dept_group" style="display: <?php echo ($selClass && strpos($selClass['class_name'], 'SS') !== false) ? 'block' : 'none'; ?>;">
        <legend>Department</legend>
        <?php 
            $exmneDeptId = isset($selExmne['exmne_dept_id']) ? $selExmne['exmne_dept_id'] : 0;
            $selDept = $conn->query("SELECT * FROM department_tbl WHERE dept_id='$exmneDeptId' ")->fetch(PDO::FETCH_ASSOC);
         ?>
         <select class="form-control" name="exDeptId">
           <option value="<?php echo $exmneDeptId; ?>"><?php echo $selDept ? $selDept['dept_name'] : 'Select Department'; ?></option>
           <?php 
             $selDepts = $conn->query("SELECT * FROM department_tbl WHERE dept_id!='$exmneDeptId' ");
             while ($selDeptRow = $selDepts->fetch(PDO::FETCH_ASSOC)) { ?>
              <option value="<?php echo $selDeptRow['dept_id']; ?>"><?php echo $selDeptRow['dept_name']; ?></option>
            <?php  }
            ?>
         </select>
     </div>
     <script>
        function toggleDeptUpdate(selectObj) {
            var selectedText = selectObj.options[selectObj.selectedIndex].text;
            if (selectedText.includes("SS")) {
                document.getElementById('update_dept_group').style.display = "block";
            } else {
                document.getElementById('update_dept_group').style.display = "none";
                document.querySelector('#update_dept_group select').value = "0";
            }
        }
     </script>

     <div class="form-group">
        <legend>Email</legend>
        <input type="" name="exEmail" class="form-control" required="" value="<?php echo $selExmne['exmne_email']; ?>" >
     </div>

     <div class="form-group">
        <legend>Password</legend>
        <input type="" name="exPass" class="form-control" required="" value="<?php echo $selExmne['exmne_password']; ?>" >
     </div>

     <div class="form-group">
        <legend>Status</legend>
        <input type="hidden" name="course_id" value="<?php echo $id; ?>">
        <input type="" name="newCourseName" class="form-control" required="" value="<?php echo $selExmne['exmne_status']; ?>" >
     </div>
  <div class="form-group" align="right">
    <button type="submit" class="btn btn-sm btn-primary">Update Now</button>
  </div>
</form>
  </div>
</fieldset>







