<?php
class User {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function register($data) {
		$this->db->query('INSERT INTO users
											(user__uid, user__pwd, user__fname, user__sname, user__email)
											VALUES (:uid, :pwd, :fname, :sname, :email)
											');

		// Bind values
		$this->db->bind(':uid', $data['uid']);
		$this->db->bind(':pwd', $data['pwd']);
		$this->db->bind(':fname', $data['fname']);
		$this->db->bind(':sname', $data['sname']);
		$this->db->bind(':email', $data['email']);

		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	// Login User
	public function login($uid, $pwd, $uidType) {
		if ($uidType == 'email') {
			// Query user__email
			$this->db->query('SELECT * FROM users WHERE user__email = :uid');
		} elseif ($uidType == 'username') {
			// Query user__uid
			$this->db->query('SELECT * FROM users WHERE user__uid = :uid');
		} else {
			return false;
		}
		// Bind uid value
		$this->db->bind(':uid', $uid);
		// Get first row from query (only one should be returned)
		$row = $this->db->single();
		// Get hashed pasword from $row object
		$hashed_pwd = $row->user__pwd;
		// Compare hashed password to unhashed user input password
		if (password_verify($pwd, $hashed_pwd)) {
			// Successful login
			$this->updateTimestamp('user__last_signed_in', $row->user__id);
			return $row;
		} else {
			// Passwor did not match
			return false;
		}
	}

	// Find user my email
	public function findUserByEmail($email) {
		$this->db->query('SELECT * FROM users WHERE user__email = :email');
		//Bind value
		$this->db->bind(':email', $email);

		$row = $this->db->single();

		// Check row
		if ($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Find user my email
	public function findUserByUid($uid) {
		$this->db->query('SELECT * FROM users WHERE user__uid = :uid');
		//Bind value
		$this->db->bind(':uid', $uid);

		$row = $this->db->single();

		// Check row
		if ($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Find user my user id
	public function getUserById($id) {
		$this->db->query('SELECT * FROM users WHERE user__id = :id');
		//Bind value
		$this->db->bind(':id', $id);

		$row = $this->db->single();
		return $row;
	}

	// Update user field with current time
	public function updateTimestamp($field, $id) {
		if (!empty($field)) {
			$this->db->query('UPDATE users SET '. $field .' = CURRENT_TIMESTAMP WHERE user__id = :id');
			// $this->db->bind(':time', date("Y-m-d H:i:s"));
			$this->db->bind(':id', $id);
			$this->db->execute();
		}
	}

}
