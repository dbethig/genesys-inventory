<?php

class Item {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getItem($itemId) {
		$this->db->query('SELECT * FROM inv_items WHERE item__id = :item__id');
		$this->db->bind(':item__id', $itemId);
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
			// echo "<p>".$container->cont__id."</p>";
			$this->db->query('SELECT * FROM inv_items WHERE item__container_id = ' .$container->cont__id);
			$set = $this->db->resultSet();
			$items[$container->cont__id] = $set;
		}
		return $this->db->rowCount() > 0 ? $items : '';
	}

	public function createItem($data) {
		$dataString = implode(', ', array_keys($data));
		$dataParamArr = $this->db->arrayToParams($data);
		$dataParams = implode(', ', $dataParamArr);
		// echo 'INSERT INTO inv_items ( ' .$dataString .' ) VALUES ( ' .$dataParams .' )';
		$this->db->query('INSERT INTO inv_items ( ' .$dataString .' ) VALUES ( ' .$dataParams .' )');
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

	public function createItemReturnRow($data) {
		if ($this->createItem($data)) {
			$newItemId = $this->db->lastId();
			$this->db->query('SELECT * FROM inv_items WHERE item__id = ' . $newItemId);
			$newItem = $this->db->single();
			return $newItem;
		} else {
			return false;
		}
	}

	public function editItem($itemId, $data) {
		$dataString = implode(', ', array_keys($data));
		$dataParamArr = $this->db->arrayToParams($data);
		$dataParams = implode(', ', $dataParamArr);
		$sql = 'UPDATE inv_items SET ';
		foreach ($data as $key => $val) {
			$sql .= "$key = :$key, ";
		}
		$sql = trim($sql, ' '); // first trim last space
		$sql = trim($sql, ','); // then trim trailing and prefixing commas
		$sql .= " WHERE item__id = :item__id";
		$this->db->query($sql);
		// Bind values
		$this->db->bindArrays($dataParamArr, $data);
		$this->db->bind(':item__id', $itemId);
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

	public function getTypes() {
		$this->db->query('SELECT * FROM item_types');
		$types = $this->db->resultSet();
		foreach ($types as $type) {
			$this->db->query('SELECT a.attr__id, a.attr__name
												FROM item_attr a
												JOIN type_details d ON a.attr__id = d.tdetails__attr_id
												WHERE d.tdetails__type_id = ' .$type->type__id
											);
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

	public function getTypeName($typeId)	{
		$type = $this->getType($typeId);
		$typeName = $type->type__name;
		return $typeName;
	}

}
