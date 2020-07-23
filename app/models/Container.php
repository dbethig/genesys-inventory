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
												:cont__inv_id,
												:cont__name,
												:cont__desc,
												:cont__capacity,
												:cont__enc
											)');
		// Bind values
		$this->db->bind(':cont__inv_id', $data['cont__inv_id']);
		$this->db->bind(':cont__name', $data['cont__name']);
		$this->db->bind(':cont__desc', $data['cont__desc']);
		$this->db->bind(':cont__capacity', $data['cont__capacity']);
		$this->db->bind(':cont__enc', $data['cont__enc']);
		return $this->db->execute() ? true : false;
		// try {
		// 	$this->db->execute();
		// 	return TRUE;
		// } catch (PDOException $e) {
		// 	$this->error = $e->getMessage();
		// 	return $this->error;
		// }
	}
	/*
	* ============================================================
	* Get a container by ID
	* ============================================================
	*/
	public function getContainerById($id) {
		$this->db->query('SELECT * FROM containers WHERE cont__id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();
		if ($row) {
			return $row;
		} else {
			return false;
		}
	}
	/*
	* ============================================================
	* Get all containers in inventory
	* ============================================================
	*/
	public function getContainers($invId) {
		$this->db->query('SELECT * FROM containers WHERE cont__inv_id = :id ORDER BY cont__order');
		$this->db->bind(':id', $invId);
		$containers = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			return $containers;
		} else {
			return False;
		}
	}
	/*
	* ============================================================
	* Update a container
	* ============================================================
	*/
	public function updateContainer($container) {
	 // Run generic update function
	 $r = $this->elementModel->updateElement('containers', $container, 'cont__id');
	 // return result of update function (true or false)
	 return $r;
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

	public function calcContainerEnc($containers) {
	 $encTotal = 0;
	 foreach($containers as $cont) {
		 if ($cont->cont__worn != 0 && $cont->cont__enc !== NULL) {
		 	$encTotal = $encTotal + $cont->cont__enc;
		 }
	 }
	 return $encTotal;
	}

	public function getCharId($contId) {
		$c = $this->getContainerById($contId);
		$this->db->query("SELECT inv__char_id FROM inventories WHERE inv__id = :id");
		$this->db->bind(':id', $c->cont__inv_id);
		$r = $this->db->single();
		if ($r) {
			return $r->inv__char_id;
		} else {
			return false;
		}
	}

	public function countContainersByInv($id) {
		$c = $this->getContainers($id);
		$n = $this->db->rowCount();
		return $n;
	}

	public function updateOrder($e, $dir)	{
		$o = $dir === 'up' ? $e->cont__order - 1 : $e->cont__order + 1;
		$this->db->query("UPDATE containers SET cont__order = $o WHERE cont__id = :id");
		$this->db->bind(':id', $e->cont__id);
		return $this->db->execute() ? true : false ;
	}

}
