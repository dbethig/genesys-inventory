<?php
/*
* Inventory Model
*/

Class Inventory {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

/*
 * ============================================================
 * Create an inventory
 * ============================================================
 */
	public function createInventory($charId) {
		$this->db->query('INSERT INTO inventories (inv__char_id) VALUES (:charId)');
		$this->db->bind(':charId', $charId);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			// Query did not execute
			return false;
		}
	}
	/*
	 * ============================================================
	 * Get all inventories for user
	 * ============================================================
	 */
	public function getInventoryByUser($userId) {
		$this->db->query('SELECT *
											FROM `inventories` I
											INNER JOIN `characters` C
											ON I.inv__char_id = C.char__id
											WHERE C.char__user_id = :userid
											');
		$this->db->bind(':userid', $userId);
		$result = $this->db->single();
		return $result;
	}
	/*
	 * ============================================================
	 * Get all inventories for character
	 * ============================================================
	 */
	public function getInventoryByCharacter($charId) {
		$this->db->query('SELECT *
											FROM inventories
											WHERE inventories.inv__char_id = :id
											');
		$this->db->bind(':id', $charId);
		$result = $this->db->single();
		if ($this->db->rowCount() <= 0) {
			return false;
		} else {
			return $result;
		}
	}
/*
 * ============================================================
 * Create an inventory and return the newly created ID as a string
 * ============================================================
 */
	public function createInventoryGetId($id) {
		if ($this->createInventory($id)) {
			$newInventoryId = $this->db->lastId();
			return $newInventoryId;
		} else {
			return false;
		}
	}
/*
 * ============================================================
 * Get the User ID of an inventory.
 * ============================================================
 *
 * Inventory's ID is passed as the param
 */
	public function getInventoryUser($invId) {
		$this->db->query('SELECT characters.char__user_id FROM characters JOIN inventories ON  characters.char__id = inventories.inv__char_id WHERE inventories.inv__id = :id');
		$this->db->bind(':id', $invId);
		$result = $this->db->single();
		return $result->char__user_id;
	}
/*
 * ============================================================
 * Delete an inventory
 * ============================================================
 */
 public function deleteInventory($Invid) {
	 $this->db->query('DELETE FROM inventories WHERE inv__id = :id');
	 // Bind values
	 $this->db->bind(':id', $Invid);
	 // Execute the query
	 if($this->db->execute()) {
		 return true;
	 } else {
		 return false;
	 }
 }

}
