<?php 
  include("../../../conn.php");
  $id = $_GET['id'];

  $selAdmin = $conn->query("SELECT * FROM admin_acc WHERE admin_id='$id' ")->fetch(PDO::FETCH_ASSOC);
 ?>

<fieldset>
	<legend><i class="fa fa-user-shield"></i> Update Admin Account</legend>
	<div class="col-md-12-r">
		<form method="post" id="updateAdminFrm">
            <input type="hidden" name="admin_id" value="<?php echo $selAdmin['admin_id']; ?>">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="admin_user" class="form-control" required="" value="<?php echo $selAdmin['admin_user']; ?>" >
			</div>

			<div class="form-group">
				<label>New Password (leave blank to keep current)</label>
				<input type="password" name="admin_pass" class="form-control" placeholder="Enter new password">
			</div>

			<div class="form-group text-right">
				<button type="submit" class="btn btn-primary btn-sm">Update Now</button>
			</div>
		</form>
	</div>
</fieldset>
