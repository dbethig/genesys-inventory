<?php

class Users extends Controller {

	public function __construct() {
		$this->userModel = $this->model('User');
	}

	// Register a user
	public function register() {
		// Check for POST data
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Process form
			// Sanitise POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// Init data
			$data = [
				'uid' => trim($_POST['uid']),
				'fname' => trim($_POST['fname']),
				'sname' => trim($_POST['sname']),
				'email' => trim($_POST['email']),
				'pwd' => trim($_POST['pwd']),
				'confirm_pwd' => trim($_POST['confirm_pwd']),
				'uid_err' => '',
				'fname_err' => '',
				'sname_err' => '',
				'email_err' => '',
				'pwd_err' => '',
				'confirm_pwd_err' => ''
			];

			// Validate email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email!';
			} elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$data['email_err'] = 'Please enter a valid email!';
			} else {
				if ($this->userModel->findUserByEmail($data['email'])) {
					// Email already exists in database
					$data['email_err'] = 'Email is already taken!';
				}
			}

			// Validate Username
			if (empty($data['uid'])) {
				$data['uid_err'] = 'Please enter a username!';
			} else {
				if($this->userModel->findUserByUid($data['uid'])) {
					// Username already exists in database
					$data['uid_err'] = 'Username is already taken!';
				}
			}

			// Validate names
			if (empty($data['fname'])) {
				$data['fname_err'] = 'Please enter your first name!';
			}
			if (empty($data['sname'])) {
				$data['sname_err'] = 'Please enter your surname!';
			}

			// Validate password
			if (empty($data['pwd'])) {
				$data['pwd_err'] = 'Please enter your password!';
			} elseif(strlen($data['pwd']) < 6) {
				$data['pwd_err'] = 'Password must be at least 6 characters!';
			}

			// Validate confirm password
			if (empty($data['confirm_pwd'])) {
				$data['confirm_pwd_err'] = 'Please confirm password!';
			} else {
				if ($data['pwd'] != $data['confirm_pwd']) {
						$data['confirm_pwd_err'] = 'Passwords do not match!';
				}
			}

			// Make sure errors are empty
			if (empty($data['uid_err']) && empty($data['email_err']) && empty($data['fname_err']) && empty($data['sname_err']) && empty($data['pwd_err']) && empty($data['confirm_pwd_err'])) {
				// Validated

				// Hash Password
				$data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);

				//Register user
				if ($this->userModel->register($data)) {
					flash('page_msg', 'You are now registered!');
					url_redirect('users/login');
				} else {
					die('Something went wrong!');
				}
			} else {
				// Load view with errors
				$this->view('users/register', $data);
			}

		} else {
			// Init data
			// This will allow submitted data to be stored and submitted back into the form incase of errors
			$data = [
				'uid' => '',
				'fname' => '',
				'sname' => '',
				'email' => '',
				'pwd' => '',
				'confirm_pwd' => '',
				'fname_err' => '',
				'sname_err' => '',
				'email_err' => '',
				'pwd_err' => '',
				'confirm_pwd_err' => ''
			];

			// Load view
			$this->view('users/register', $data);
		}
	}

	// Login a user
	public function login() {
		// Check for POST data
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Process form

			// Sanitise POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// Init data
			$data = [
				'uid' => trim($_POST['uid']),
				'pwd' => trim($_POST['pwd']),
				'uid_err' => '',
				'pwd_err' => '',
			];

			$uidType = '';

			// Validate uid field
			if (empty($data['uid'])) {
				$data['uid_err'] = 'Please enter an email or username!';
			} else {
				// Check uid type (email or username)
				if (strpos($data['uid'], '@') !== false) {
					// Is email
					// Validate email
					if(!filter_var($data['uid'], FILTER_VALIDATE_EMAIL)) {
						$data['uid_err'] = 'Please enter a valid email!';
					} else {
						// Check for user email
						if ($this->userModel->findUserByEmail($data['uid'])) {
							// User found
							$uidType = 'email';
						} else {
							$data['uid_err'] = 'No user found with that email or username!';
						}
					}
				} else {
					// Is username
					// Check for user username
					if ($this->userModel->findUserByUid($data['uid'])) {
						// User found
						$uidType = 'username';
					} else {
						$data['uid_err'] = 'No user found with that email or username!';
					}
				}
			}

			// Validate password
			if (empty($data['pwd'])) {
				$data['pwd_err'] = 'Please enter your password!';
			}

			// Make sure errors are empty
			if (empty($data['uid_err']) && empty($data['pwd_err'])) {
				// Validated
				// Check and set logged in user
				$loggedInUser = $this->userModel->login($data['uid'], $data['pwd'], $uidType);

				if ($loggedInUser) {
					// Loggin successful
					// Create Session
					$this->createUserSession($loggedInUser);
					$this->view('pages/index');
				} else {
					// Login failed
					$data['pwd_err'] = 'Incorrect password!';
					// Return to the login page with input & error data
					$this->view('users/login', $data);
				}
			} else {
				// Load view with errors
				$this->view('users/login', $data);
			}

		} else {
			// Init data
			$data = [
				'uid' => '',
				'pwd' => '',
				'uid_err' => '',
				'pwd_err' => ''
			];

			// Load view
			$this->view('users/login', $data);
		}
	}

	// Create session for user on login
	public function createUserSession($user) {
		$_SESSION['user_id'] = $user->user__id;
		$_SESSION['user_uid'] = $user->user__uid;
		$_SESSION['user_email'] = $user->user__email;
		$_SESSION['user_fname'] = $user->user__fname;
		$_SESSION['user_sname'] = $user->user__sname;
		url_redirect('index');
	}

	public function logout() {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_email']);
		unset($_SESSION['user_fname']);
		unset($_SESSION['user_sname']);
		session_destroy();
		url_redirect('pages/index');
	}

	public function myAccount() {
		$data = [];
		$this->view('users/myaccount', $data);
	}
}
