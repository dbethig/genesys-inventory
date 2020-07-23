<?php
/*
* Character Model
*/

Class Character {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	// Get all characters for user
	public function getCharacters($userId) {
		$this->db->query('SELECT *
											FROM `characters` C
											INNER JOIN `users` U
											ON C.char__user_id = U.user__id
											WHERE U.user__id = :userid
											');
		$this->db->bind(':userid', $userId);
		$result = $this->db->resultSet();
		return $result;
	}

	public function createCharacterGetId($data) {
		if ($this->createCharacter($data)) {
			$newCharId = $this->db->lastId();
			return $newCharId;
		} else {
			throw new CustomException;
			return false;
		}
	}

	public function createCharacterReturnRow($data) {
		if ($this->createCharacter($data)) {
			$newCharId = $this->db->lastId();
			$this->db->query('SELECT * FROM characters WHERE char__id = ' . $newCharId);
			$newChar = $this->db->single();
			return $newChar;
		} else {
			return false;
		}
	}

	// Create a new character
	public function createCharacter($data) {
		$dataParamArr = $this->db->arrayToParams($data);
		$dataParams = implode(', ', $dataParamArr);
		// Query to insert new record into 'characters' table
		$this->db->query('INSERT INTO characters (
			char__user_id,
			char__name,
			char__soak,
			char__enc_total,
			char__enc_curr,
			char__characteristic_brawn,
			char__characteristic_agility,
			char__characteristic_intellect,
			char__characteristic_cunning,
			char__characteristic_willpower,
			char__characteristic_presence
		) VALUES (' . $dataParams .')');
		// Bind values
		$this->db->bindArrays($dataParamArr, $data);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			// Query did not execute
			return false;
		}
	}

	// Edit a character
	public function updateCharacter($data) {
		// Query to insert new record into 'characters' table
		$this->db->query('UPDATE characters
											SET
												char__name = :name,
												char__characteristic_brawn = :brawn,
												char__characteristic_agility = :agility,
												char__characteristic_intellect = :intellect,
												char__characteristic_cunning = :cunning,
												char__characteristic_willpower = :will,
												char__characteristic_presence = :presence,
												char__soak = :soak,
												char__enc_total = :enc_total,
												char__enc_curr = :enc_curr
											WHERE char__id = :id'
										);
		// Bind values
		$this->db->bind(':id', $data['char__id']);
		$this->db->bind(':name', $data['char__name']);
		$this->db->bind(':brawn', $data['char__characteristic_brawn']);
		$this->db->bind(':agility', $data['char__characteristic_agility']);
		$this->db->bind(':intellect', $data['char__characteristic_intellect']);
		$this->db->bind(':cunning', $data['char__characteristic_cunning']);
		$this->db->bind(':will', $data['char__characteristic_willpower']);
		$this->db->bind(':presence', $data['char__characteristic_presence']);
		$this->db->bind(':soak', $data['char__soak']);
		$this->db->bind(':enc_total', $data['char__enc_total']);
		$this->db->bind(':enc_curr', $data['char__enc_curr']);

		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function getCharacterById($id) {
		$this->db->query('SELECT * FROM characters WHERE char__id = :id');
		$this->db->bind(':id', $id);
		if ($this->db->single()) {
			$row = $this->db->single();
			return $row;
		} else {
			throw new CustomException();
		}
	}

	public function deleteCharacter($id) {
		$this->db->query('DELETE FROM characters WHERE char__id = :id');
		// Bind values
		$this->db->bind(':id', $id);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function updateEncCurrent($id, $enc) {
		$this->db->query('UPDATE characters
											SET char__enc_curr = :enc
											WHERE char__id = :id
										');
		$this->db->bind(':enc', $enc);
		$this->db->bind(':id', $id);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function updateEncTotal($id, $enc) {
		// Get brawn value of character
		$this->db->query('SELECT char__characteristic_brawn FROM characters WHERE char__id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();
		$brawn = $row->char__characteristic_brawn;
		// Calculate enc total (Brawn + worn item total + 5)
		$encTotal = $brawn + $enc + 5;
		// Update character enc_total
		$this->db->query('UPDATE characters
											SET char__enc_total = :enc
											WHERE char__id = :id
										');
		$this->db->bind(':enc', $encTotal);
		$this->db->bind(':id', $id);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

}
