<?php

class Item {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getItem($id) {
		$this->db->query('SELECT * FROM inv_items WHERE item__id = :item__id');
		$this->db->bind(':item__id', $id);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		} else {
			return false;
		}
	}

	public function getItems($containers) {
		$items = [];
		foreach ($containers as $container) {
			$contId = $container->cont__id;
			// echo "<p>Container ID: $contId</p>";
			$this->db->query('SELECT * FROM inv_items WHERE item__container_id = ' .$contId);
			$set = $this->db->resultSet();
			$this->db->rowCount() > 0 ? $items[$contId] = $set : '';
		}
		return $items !== NULL ? $items : '';
	}

	public function createItem($data) {
		$keyString = implode(', ', array_keys($data));
		$paramArr = $this->db->arrayToParams($data);
		$params = implode(', ', $paramArr);
		$this->db->query("INSERT INTO inv_items ($keyString) VALUES ($params)");
		// printAndDie($data);
		// Bind values
		$this->db->bindArrays($paramArr, $data);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			// Query did not execute
			return false;
		}
	}

	public function createItemReturnRow($data) {
		if ($this->createItem($data)) {
			$newId = $this->db->lastId();
			$this->db->query('SELECT * FROM inv_items WHERE item__id = ' . $newId);
			$newRow = $this->db->single();
			return $newRow;
		} else {
			return false;
		}
	}

	public function updateItem($data) {
		// Sepparate the id from the array so it can't be updated.
		$id = $data['item__id'];
		unset($data['item__id']);
		// Split the array into parameters to bind them to the values dynamically
		$paramArr = $this->db->arrayToParams($data);
		$params = implode(', ', $paramArr);
		// printAndDie($data);
		// Build Query
		$sql = 'UPDATE inv_items SET ';
		// Add fields and placeholders
		// placeholders must have the same name as the fields
		foreach ($data as $key => $val) {
			$sql .= "$key = :$key, ";
		}
		$sql = trim($sql, ' '); // first trim last space
		$sql = trim($sql, ','); // then trim trailing and prefixing commas
		$sql .= " WHERE item__id = :item__id";
		$this->db->query($sql);
		// Bind values
		$this->db->bindArrays($paramArr, $data);
		$this->db->bind(':item__id', $id);
		// Execute the query
		if($this->db->execute()) {
			return true;
		} else {
			// Query did not execute
			return false;
		}
	}

	public function deleteItem($id) {
		$this->db->query('DELETE FROM inv_items WHERE item__id = :id');
		$this->db->bind(':id', $id);
		if($this->db->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteItems($items) {
		if (empty($items)) {
			return true;
		}
		foreach($items as $item) {
			$this->db->query('DELETE FROM inv_items WHERE item__id = :id');
			$this->db->bind(':id', $item->item__id);
			if(!$this->db->execute()) {
				return false;
			}
		}
		return true;
	}

	public function getContainerId($itemId)	{
		$this->db->query('SELECT item__container_id FROM inv_items WHERE item__id = :item__id');
		$this->db->bind(':item__id', $itemId);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row->item__container_id;
		} else {
			return false;
		}
	}

	public function checkOwner($itemId, $charId) {
		$contId = $this->getContainerId($itemId);
		$this->db->query('SELECT cont__inv_id FROM containers WHERE cont__id = :id');
		$this->db->bind(':id', $contId);
		$row = $this->db->single();
		$invId = $row->cont__inv_id;
		if ($this->db->rowCount() > 0) {
			$this->db->query('SELECT inv__char_id FROM inventories WHERE inv__id = :id');
			$this->db->bind(':id', $invId);
			$row = $this->db->single();
			if ($row->inv__char_id == $charId) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

/*	public function getTypes() {
		$this->db->query('SELECT * FROM item_types');
		$types = $this->db->resultSet();
		foreach ($types as $type) {
			$qry = 'SELECT a.attr__id, a.attr__name FROM item_attr a JOIN type_details d ON a.attr__id = d.tdetails__attr_id WHERE d.tdetails__type_id = ' .$type->type__id;
			$this->db->query($qry);
			$attributes = $this->db->resultSet();
			if ($this->db->rowCount() > 0) {
				$type->attributes = $attributes;
				foreach ($attributes as $attr) {
					$attrName = strtolower($attr->attr__name);
					$this->db->query("SELECT item__$attrName FROM inv_items");
					$attr->meta = $this->db->getMeta();
				}
			} else {
				$type->attributes = '';
			}
		}

		return $types;
	}
*/
	public function getTypes()	{
		$this->db->query('SELECT * FROM item_types');
		$types = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			return $types;
		} else {
			return false;
		}
	}

	public function getType($typeId) {
		$this->db->query('SELECT * FROM item_types WHERE type__id = :id');
		$this->db->bind(':id', $typeId);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		} else {
			return false;
		}
	}
	public function getAttributesWithMeta($typeId) {
		$type = $this->getAttributes($typeId);
		if ($this->db->rowCount() > 0) {
			foreach ($type as $attr) {
				$attrName = strtolower($attr->attr__name);
				$this->db->query("SELECT item__$attrName FROM inv_items");
				$meta = $this->db->getMeta();
				$attr->meta = $meta['native_type'];
			}
			return $type;
		} else {
			return false;
		}
	}


	public function getAttributes($itemTypeId) {
		$this->db->query('SELECT a.attr__id, a.attr__name
											FROM item_attr a
											JOIN type_details d ON a.attr__id = d.tdetails__attr_id
											WHERE d.tdetails__type_id = ' .$itemTypeId
										);
		$attributes = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			return $attributes;
		} else {
			return false;
		}
	}

	public function getTypeName($typeId)	{
		$type = $this->getType($typeId);
		$typeName = $type->type__name;
		return $typeName;
	}

	public function calcItemEnc($containers) {
		$encTotal = 0;
		foreach ($containers as $contId => $items) {
			$this->db->query('SELECT cont__worn FROM containers WHERE cont__id = ' .$contId);
			$contWorn = $this->db->single();
			if ($contWorn && $contWorn !== 0) { // If container found and it is 'worn'
				foreach ($items as $item) {
					$encTotal = $encTotal + $item->item__enc_total; // add each items enc to total
				}
			}
		}
		return $encTotal;
	}

}
