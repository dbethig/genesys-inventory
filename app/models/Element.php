<?php
/*
* General Model
*/
Class Element {
	private $db;

	public function __construct() {
		$this->db = new Database;
	}
/*
	* ============================================================
	* Get an element
	* ============================================================
	*
	* Dynamically fetch a single row from a table
	* >	'table name',
	*	>	Array for WHERE[
				['c'] => [
					'WHERE condition' => value,
					'WHERE condition' => value
				],
				['o'] => 'operator'
			] ,
	* >	'SELECT field/s'
	* -----------------------------------------------------------
	* E.G.
	* getElement('containers',
								array [
									['c'] => [
										'cont__inv_id' => 20,
										'cont__order' => 3
									],
									['o'] => 'OR'
								],
								'cont__name, cont__desc');
	* -----------------------------------------------------------
	*/
	public function getElement($t, $w, $s = '*')	{
		// WHERE conditions
		$p = $this->db->arrayToParams($w['c']);
		$cArray = [];
		foreach ($w['c'] as $key => $value) {
			array_push($cArray, "$key = :$key");
		}
		// Set WHERE operator (AND default)
		$o  = isset($w['o']) ? $w['o'] : 'AND';
		// Make string of WHERE conditions
		$where = implode(" $o ", $cArray);
		// Set query string
		$qry = "SELECT $s FROM $t WHERE $where";
		// printAndDie($qry, 'QRY');
		$this->db->query($qry);
		$this->db->bindArrays($p, $w['c']);
		$r = $this->db->single();
		// printAndDie($r);
		return $r ? $r : false;
	}
/*
	* ============================================================
	* Get an element by ID
	* ============================================================
	*
	* Dynamically fetch a single row from a table
	* 'table name', 'primary key field', primary key value , 'select field/s'
	* E.G.
	* getElement('containers', 'cont__id', 12, 'cont__name, cont__desc');
	*/
	public function getElementById($t, $pk, $id, $s = '*')	{
		$w['c'] =	[
			$pk => $id
		];
		$e = $this->getElement($t, $w, $s);
		return $e;
	}

	public function getElementArray($t, $pk, $v, $s = '*')	{
		$e = (array) $this->getElementById($t, $pk, $v, $s);
		return $e;
	}
 /*
	* ============================================================
	* Create an empty element
	* ============================================================
	*
	* Empty element is used to populate the page when creating a new element
	* 'table name', 'assoc array key', fields to ignore (array or str)
	* E.G.
	* createEmptyElement('containers', 'cont', 'cont__inv_id');
	*/
	public function createEmptyElement($t, $k, $i = null)	{
		$d[$k] = $this->tableColsToAssocArray($t, $i);
		$d['errors'] = $this->emptyErrorArray($d[$k]);
		return $d;
	}
 /*
 	* ============================================================
 	* Create an element
 	* ============================================================
 	*
 	* Dynamically creat a single row in a table
 	* 'table name', (array) element
 	* E.G.
 	* updateElement('containers', $data['cont']);
 	*/
	public function createElement($t, $e) {
		if(!is_array($e)){(array) $e;}
		$keys = implode(', ', array_keys($e));
		$paramArr = $this->db->arrayToParams($e);
		$params = implode(', ', $paramArr);
		$sql = "INSERT INTO $t ($keys) VALUES ($params)";
		// printAndDie($sql, 'SQL');
		$this->db->query($sql);
		// Bind values
		$this->db->bindArrays($paramArr, $e);
		// Execute the query
		return $this->db->execute() ? true : false;
	}
 /*
	* ============================================================
	* Update an element
	* ============================================================
	*
	* Dynamically update a single row of a table
	* 'table name', (array) element, 'primary key field name', [WHERE criteria]
	* E.G.
	* updateElement('containers', $data['cont'], 'cont__id', ['cont__inv_id' =>]);

	array = [
		['c'] => [
			'cont__inv_id' => ':cont__inv_id',
			'cont__order' => 2
		],
			['o'] => 'AND' (default)
	]
	WHERE cont__inv_id = :cont__inv_id AND
	*/
	public function updateElement($t, $e, $pk, $w = null) {
		if ($w) {
			$c = array_walk($w['c'], function($v, $k) {
				return "$k = $v";
			});
			$o  = isset($w['o']) ? $w['o'] : 'AND';
			$c = implode(" $o ", $c);
		} else {
			$w = "$pk = :pk";
		}
		// Sepparate the id from the array so it can't be updated.
		$id = $e[$pk];
		unset($e[$pk]);
		// Split the array into parameters to bind them to the values dynamically
		$paramArr = $this->db->arrayToParams($e);
		$params = implode(', ', $paramArr);

		// Build Query
		$qry = "UPDATE $t SET ";
		// Add fields and placeholders
		// placeholders must have the same name as the fields
		foreach ($e as $key => $val) {
			$qry .= "$key = :$key, ";
		}
		$qry = trim($qry, ' '); // first trim last space
		$qry = trim($qry, ','); // then trim trailing and prefixing commas
		$qry .= " WHERE $w";
		$this->db->query($qry);
		// Bind values
		$this->db->bindArrays($paramArr, $e);
		$this->db->bind(":pk", $id);
		// Execute the query
		return $this->db->execute() ? true : false;
	}
/*
 * ============================================================
 * Update an element
 * ============================================================
 * See function above.
 */
	public function updateElements($t, $a, $pk, $w = null) {
		if (is_array($a)) {
			foreach ($a as $e) {
				if (!empty($e)) {
					$this->updateElement($t, $e, $pk, $w);
				}
			}
		} else {
			$this->updateElement($t, $a, $pk, $w);
		}
	}
 /*
 	* ============================================================
 	* Delete an element
 	* ============================================================
 	*
 	* Dynamically delete a single row from a table
 	* 'table name', id , 'primary key field name'
 	* E.G.
 	* deleteElement('containers', 44, 'cont__id');
 	*/
	public function deleteElement($t, $id , $pk) {
		$this->db->query("DELETE FROM $t WHERE $pk = :id");
		$this->db->bind(':id', $id);
		return $this->db->execute() ? true : false;
	}

 /*
 	* ============================================================
 	* Fetch & return table column names
 	* ============================================================
	*/
	public function tableColsToAssocArray($t, $ignore = null) {
		// $c = $this->getColumnsByTable($t);
		$c = array_fill_keys($this->getColumnsByTable($t), $val = '');
		// $merged = array_merge($arr, $columnAssoc);
		if ($ignore) {
			if (is_array($ignore)) {
				foreach ($ignore as $field) {
					unset($c[$field]);
				}
			} else {
				unset($c[$ignore]);
			}
		}
		return $c;
	}

	public function getColumnsByTable($t) {
		$this->db->query("DESCRIBE $t");
		$cols = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			unset($cols[0]);
			$names = array_map(function($col) {
				return $col->Field;
			}, $cols);
			return (array) $names;
		} else {
			return False;
		}
	}

	public function validateIntergers($data, $arr) {
		$e = [];
		foreach ($arr as $f => $m) {
			if (isset($data[$f])) {
				if (!is_numeric($data[$f]) && !empty($data[$f])) {
					$e[$f .'_err'] = $this->writeArrayError($f, $m);
				}
			}
		}
		return $e;
	}

	public function emptyErrorArray($f) {
		$e = [];
		foreach ($f as $key => $value) {
			$e[$key] = '';
		}
		return $e;
	}

	public function updateField($t, $f, $pk, $v) {
		$this->db->query("UPDATE $t SET $f WHERE $pk = :id");
		$this->db->bind(':id', $v);
	}

}
