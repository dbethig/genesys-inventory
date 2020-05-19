<?php flash('page_msg'); ?>
<?php flash('page_err'); ?>
<div class="row">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
    	<h2>Login</h2>
			<form action="<?php echo URLROOT; ?>/users/login" method="post">
					<div class="form-group">
						<label for="uid">Email or Username<sup>*</sup>:</label>
						<input type="text" name="uid" class="form-control form-control-lg <?php echo (!empty($data['uid_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['uid']; ?>">
						<span class="invalid-feedback"><?php echo $data['uid_err']; ?></span>
					</div>
					<div class="form-group">
						<label for="pwd">Password<sup>*</sup>:</label>
						<input type="password" name="pwd" class="form-control form-control-lg <?php echo (!empty($data['pwd_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['pwd']; ?>">
						<span class="invalid-feedback"><?php echo $data['pwd_err']; ?></span>
					</div>
					<div class="row">
					  <div class="col">
					    <input type="submit" value="Login" class="btn btn-success btn-block">
					  </div>
						<div class="col">
							<a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">No account? Register</a>
						</div>
					</div>
			</form>
    </div>
  </div>
</div>
