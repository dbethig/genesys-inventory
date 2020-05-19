<?php
/*
* Inventory Model
*/

Class Container {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}
/*
 * ============================================================
 * Create a container
 * ============================================================
 */
	public function createContainer($data) {
		$this->db->query('INSERT INTO `containers` (
												`cont__inv_id`,
												`cont__name`,
												`cont__desc`,
												`cont__capacity`,
												`cont__enc`
											)
											VALUES (
												:inv_id,
												:name,
												:descr,
												:capacity,
												:enc
											)');
		// Bind values
		$this->db->bind(':inv_id', $data['inv_id']);
		$this->db->bind(':name', $data['name']);
		$this->db->bind(':descr', $data['descr']);
		$this->db->bind(':capacity', $data['capacity']);
		$this->db->bind(':enc', $data['enc']);
		try {
			$this->db->execute();
			return TRUE;
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			return $this->error;
		}
	}

	public function getContainers($invId) {
		$this->db->query('SELECT * FROM containers WHERE containers.cont__inv_id = ' . $invId);
		$containers = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			return $containers;
		} else {
			return False;
		}
	}
/*
 * ============================================================
 * Delete a container
 * ============================================================
 */
	public function deleteContainer($id) {
		$this->db->query('DELETE FROM containers WHERE containers.cont__id = :id');
		$this->db->bind(':id', $id);
		try {
			$this->db->execute();
			return true;
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			 return $this->error;
		}
	}
/*
 * ============================================================
 * Delete all containers
 * ============================================================
 */
 public function deleteContainers($containers) {
	 foreach($containers as $cont) {
		 $this->db->query('DELETE FROM containers WHERE cont__id = :id');
		 // Bind values
		 $this->db->bind(':id', $cont->cont__id);
		 // Execute the query
		 if(!$this->db->execute()) {
			 return false;
		 }
	 }
		return true;
 }

}
