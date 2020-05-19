<?php
/*
	* PDO Database Class
	* Connect to Database
	* Create prepared statements
	* Bind params
	* Return rows and results
*/
class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pwd = DB_PWD;
	private $dbName = DB_NAME;

	private $dbh;
	protected $stmt;
	private $error;

	public function __construct() {
		//Set DNS
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		// Create new PDO instance
		 try {
			 $this->dbh = new PDO($dsn, $this->user, $this->pwd, $options);
		 } catch(PDOException $e) {
			 $this->error = $e->getMessage();
			 echo $this->error;
		 }
	}

	// Prepare stmt with qry
	public function query($sql) {
		$this->stmt = $this->dbh->prepare($sql);
	}
/*
 * ====================================================
 * Array to PDO bind params
 * ====================================================
 * EXAMPLE:
 * $data['user_id' => '1', 'charname' => 'John', ...]
 * returns $result[':user_id', ':charname', ...]
 */
	public function arrayToParams($data) {
		$result = array_map(function($s) {return ':' .$s;}, array_keys($data));
		return $result;
	}
/*
 * ====================================================
 * Bind values
 * ====================================================
 */
	public function bind($param, $val, $type = null) {
		if (is_null($type)) {
			switch(true) {
				case is_int($val):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($val):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($val):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}

		$this->stmt->bindValue($param, $val, $type);
	}
/*
 * ====================================================
 * Bind an array of values
 * ====================================================
 */
	public function bindArrays($params, $vals, $type = null) {
		foreach ($params as $param) {
			$p = substr($param, 1);
			foreach ($vals as $key => $val) {
				if ($p == $key) {
					if (is_null($type)) {
						switch(true) {
							case is_int($val):
								$type = PDO::PARAM_INT;
								break;
							case is_bool($val):
								$type = PDO::PARAM_BOOL;
								break;
							case is_null($val):
								$type = PDO::PARAM_NULL;
								break;
							default:
								$type = PDO::PARAM_STR;
						}
					}
					// echo "<p>BIND: $param, $val, $type</p>";
					$this->stmt->bindValue($param, $val, $type);
				}
			}
		}
	}

	// Execute the prepared statement
	public function execute() {
		return $this->stmt->execute();
	}

	// Get result set as array of objects
	public function resultSet() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Get single record as objects
	public function single() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}

	// Get last insterted row id
	public function lastId() {
		return $this->dbh->lastInsertId();
	}

	// Get row count
	public function rowCount() {
		return $this->stmt->rowCount();
	}

	public function getMeta($col = 0) {
		$this->execute();
		return $this->stmt->getColumnMeta($col);
	}
}
