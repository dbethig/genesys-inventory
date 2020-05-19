<?php flash('page_msg'); ?>
<?php flash('page_err'); ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
    	<h2>Create An Account</h2>
			<p>Please fill out the form</p>
			<form action="<?php echo URLROOT; ?>/users/register" method="post">
				<div class="form-group">
					<label for="uid">Username<sup>*</sup>:</label>
					<input type="text" name="uid" class="form-control form-control-lg <?php echo (!empty($data['uid_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['uid']; ?>">
					<span class="invalid-feedback"><?php echo $data['uid_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="fname">First Name<sup>*</sup>:</label>
					<input type="text" name="fname" class="form-control form-control-lg <?php echo (!empty($data['fname_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['fname']; ?>">
					<span class="invalid-feedback"><?php echo $data['fname_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="sname">Last Name<sup>*</sup>:</label>
					<input type="text" name="sname" class="form-control form-control-lg <?php echo (!empty($data['sname_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['sname']; ?>">
					<span class="invalid-feedback"><?php echo $data['sname_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="email">Email<sup>*</sup>:</label>
					<input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['email']; ?>">
					<span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="pwd">Password<sup>*</sup>:</label>
					<input type="password" name="pwd" class="form-control form-control-lg <?php echo (!empty($data['pwd_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['pwd']; ?>">
					<span class="invalid-feedback"><?php echo $data['pwd_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="confirm_pwd">Confirm Password<sup>*</sup>:</label>
					<input type="password" name="confirm_pwd" class="form-control form-control-lg <?php echo (!empty($data['confirm_pwd_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['confirm_pwd']; ?>">
					<span class="invalid-feedback"><?php echo $data['confirm_pwd_err']; ?></span>
				</div>
				<div class="row">
				  <div class="col">
				    <input type="submit" value="Register" class="btn btn-success btn-block">
				  </div>
					<div class="col">
						<a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
					</div>
				</div>
			</form>
    </div>
  </div>
</div>
