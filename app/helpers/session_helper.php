<?php
session_start();

/*
 * Flash message helper
 * Examples:
 * flash('register_failure', 'There are some errors in your details', 'alert alert-danger');
 * flash('register_success', 'you are now registered!');
 * DISPLAY IN VIEW: <?php echo flash('register_success'); ?>
 */
function flash($name ='', $msg = '', $class = 'alert alert-success') {
	if (!empty($name)) {
	if (!empty($msg)/* && empty($_SESSION[$name]) */) {
			if (!empty($_SESSION[$name])) {
				unset($_SESSION[$name]);
			}
			if (!empty($_SESSION[$name. '_class'])) {
				unset($_SESSION[$name. '_class']);
			}
			$_SESSION[$name] = $msg;
			$_SESSION[$name. '_class'] = $class;
		} elseif(empty($msg) && !empty($_SESSION[$name])) {
			$class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
			echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
			unset($_SESSION[$name]);
			unset($_SESSION[$name. '_class']);
		}
	}
}


function isLoggedIn() {
	if (isset($_SESSION['user_id'])) {
		return true;
	} else {
		return false;
	}
}
