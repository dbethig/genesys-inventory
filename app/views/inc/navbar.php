<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
	  <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="
					<?php echo URLROOT; ?>">Home</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo URLROOT; ?>/characters">My Characters</a>
	      </li>
	    </ul>

			<ul class="navbar-nav ml-auto">
				<?php if(isset($_SESSION['user_id'])): ?>
					<span class="nav-item navbar-text mr-5">Welcome <?php echo $_SESSION['user_fname']; ?></span>
					<li class="nav-item">
					 <a class="nav-link" href="<?php echo URLROOT; ?>/users/my-account">My Account</a>
				 </li>
					<li class="nav-item">
					 <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
				 </li>
				<?php else : ?>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
	      </li>
	    </ul>
		<?php endif; ?>
	  </div>
	</div>
</nav>
