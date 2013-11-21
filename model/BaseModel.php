<?php

/**
 * The base model
 * 
 * @author Alann Dragin <a.dragin@insta.fr>
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
abstract class BaseModel {

	/**
	 * The PDO instance
	 * @var [PDO Object]
	 */
	protected $db;

	/**
	 * The Database host name <b>REQUIRED</b>
	 * @var string
	 */
	private $host;

	/**
	 * the database name  <b>REQUIRED</b>
	 * @var string
	 */
	protected $database;

	/**
	 * The database user name <b>REQUIRED</b>
	 * @var string
	 */
	private $user;

	/**
	 * The database password <b>REQUIRED</b>
	 * @var string
	 */
	private $password;

	/**
	 * The DataBase table name <b>REQUIRED</b>
	 * @var string
	 */
	protected $table_name;

	/**
	 *  The primary key field name or name in a table
	 * @var integer
	 */
	protected $primary_Key;

	/**
	 * Constructor
	 * @param string $table_name The DataBase table name <b>REQUIRED</b>
	 * @param int $primary_Key The primary key field name <b>OPTIONAL</b>
	 */
	function __construct(string $table_name, int $primary_Key) {
		$this->setHost('localhost');
		$this->setUser('root');
		$this->setPassword('');
		$this->setDatabase('shuttle');
		$this->setTable_name($table_name);
		$this->setPrimary_Key($primary_Key);
		$this->init();
	}

	/**
	 * Initialise PDO Object
	 * @throws Exception PDOException
	 */
	public function init() {
		try {
			$this->db = new PDO('mysql:host=' . $this->getHost() . ';dbname=' . $this->getDatabase(), $this->getUser(), $this->getPassword());
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->db->exec("SET NAMES 'UTF8'");
		} catch (PDOException $ex) {
			print "Unable to connect to Database ! Check configuration in \"init()\" method !\nERROR : !" . $ex->getMessage();
		}
	}

	/**
	 * Close Database connexion
	 */
	public function close() {
		$this->db = NULL;
	}

	/**
	 * Load all data from a table delimit by a $limit and $offset parameter
	 * @param int $offset <b>REQUIRED</b> Number of lines to load
	 * @param int $limit <b>REQUIRED</b> Start load from this limit
	 * @return array <b>REQUIRED</b> Value founded or array of effor message and status
	 * @throws Exception <b>PDOException</b> On ERROR
	 */
	public function loadAll(int $offset = 0, int $limit = 0) {
		try {
			$sql = 'SELECT * FROM ' . $this->getTable_name() . " LIMIT :limit OFFSET :offset";
			$loadAll = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$loadAll->execute(array(':limit' => $limit, ':offset' => $offset));
			$status = $loadAll->fetchAll();
		} catch (Exception $ex) {
			$status = array(
				"msg"=>"Error Loading Data",
				"status"=>FALSE
				);
			print "Call \"loadAll\" method\n Unable to load all data from" . $this->getTable_name() . "\nERROR ! : " . $ex->getMessage();
		}
		return $status;
	}

	/**
	 * Load data with $id parameter
	 * @param int $id <b>REQUIRED</b> The Primary Key
	 * @return array Fetch assoc array
	 * @throws Exception <b>PDOException</b> On ERROR
	 */
	public function loadById(int $id) {
		$sql = 'SELECT * FROM' . $this->getTable_name() . " WHERE " . $this->getPrimary_Key() . "= :id";
		try {
			$loadById = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO:: CURSOR_FWDONLY));
			$loadById->execute(array(':id' => $id));
			$status = $loadById->fetch();
		} catch (Exception $ex) {
			$status = array(
				"msg"=>"error",
				"status"=>FALSE
				);
			print "Call \"loadById\" method\n Unable to load id : '$id' from" . $this->getTable_name() . " \nERROR ! : " . $ex->getMessage();
		}
		return $status;
	}


	/**
	 * Delete data in table by $id as parameter
	 * @param int $id <b>REQUIRED</b> Primary key ID
	 * @return boolean <b>TRUE</b> on succes. <b>FALSE</b> either !
	 * @throws Exception <b>PDOException</b> On ERROR
	 */
	public function deleteById(int $id) {
		$sql = "DELETE FROM " . $this->getTable_name() . " WHERE" . $this->getPrimary_Key() . "= :id";
		try {
			$delete_sql = $this->db->prepare($sql);
			$this->db->beginTransaction();
			$delete_sql->execute(array(':id' => $id));
			$this->db->commit();
			$delete_sql->closeCursor();
			$status = TRUE;
		} catch (Exception $ex) {
			$this->db->rollBack();
			print "Call \"deleteById\" method \nUnable to delete id : '$id' from" . $this->getTable_name() . " \nERROR ! : " . $ex->getMessage();
			$status = FALSE;
		}
		return $status;
	}

	/**
	 * Update data in table with an array of data
	 * @param int $id Primary key where to update
	 * @param array $data Array of value to update
	 * @return boolean <b>TRUE</b> on succes. <b>FALSE</b> either !
	 * @throws Exception <b>PDOException</b> On ERROR
	 */
	public function updateFields(int $id, array $data) {
		$flag = 0;
		$array_values_update = array();
		$array_execute = array();
		$i = 1;
		$j = 1;
		try {

			$sql = "UPDATE " . $this->getTable_name() . " SET ";

			foreach ($data as $field => $value) {
				if ($flag == 0) {
					$sql.=' ' . $field . ' = :value' . $i;
					$flag = 1;
				} else {
					$sql.=' ' . ', ' . $field . ' = :value' . $i;
				}

				array_push($array_values_update, $value);
				$i++;
			}

			$sql.=$this->getPrimary_Key() . ' = :id';

			foreach ($array_values_update as $values) {
				array_push($array_execute, array(':values' . $j => $values));
				$j++;
			}

			array_push($array_execute, array(':id' => $id));

			$update = $this->db->prepare($sql);
			$this->db->beginTransaction();
			$update->execute($array_execute);
			$this->db->commit();
			$update->closeCursor();
			$status = TRUE;
		} catch (Exception $ex) {
			$this->db->rollBack();
			print "Call \"updateFields\" method \nUnable to update id : ['$id'] and data [" . var_dump($data) . "] from" . $this->getTable_name() . " ERROR ! :" . $ex->getMessage();
			$status = FALSE;
		}
		return $status;
	}

	/**
	 * Insert data into database
	 * @param array $data Array of value to insert
	 * @return boolean <b>TRUE</b> on succes. <b>FALSE</b> either !
	 * @throws Exception <b>PDOException</b> On ERROR
	 */
	public function insertData(array $data) {

		$fields = array();
		$values = array();
		$flag = 0;

		$sql = "INSERT INTO " . $this->getTable_name() . " (";

		foreach ($data as $field => $values) {

			array_push($fields, $field);
			array_push($values, $value);
		}

		foreach ($fields as $field) {

			if ($flag == 0) {
				$sql.=$field;
				$flag = 1;
			}
			$sql.=", " . $field;
		}

		$sql.=")";

		$sql.=" VALUES (";
		foreach ($values as $value) {
			$sql.='?,';
			if (end($values)) {
				$sql.='?)';
			}
		}

		$insert = $this->db->prepare($sql);
		try {
			$this->db->beginTransaction();
			$insert->execute($value);
			$this->db->commit();
			$insert->closeCursor();
			$status = TRUE;
		} catch (Exception $ex) {
			$this->db->rollBack();
			print "Call \"insertData\" method \nUnable to insert data [" . var_dump($data) . "] from" . $this->getTable_name() . " ERROR ! :" . $ex->getMessage();
			$status = FALSE;
		}
		return $status;
	}

	/**
	 * Update data if primary key exist else insert data
	 * @param array $dataArray of value to save
	 * @return boolean <b>TRUE</b> on succes. <b>FALSE</b> either !
	 */
	public function save(array $data) {
		if (array_key_exists($this->getPrimary_Key(), $data)) {
			$status = updateFields($this->getPrimary_Key(), $data);
		} else {
			$status = $this->insertData($data);
		}
		print "Call \"save\" method \nUnable to save data [" . var_dump($data) . "] from" . $this->getTable_name() . " ERROR ! :" . $ex->getMessage();
		return $status;
	}

	/**
	 * Get [PDO Object] Instance
	 * Please do not use !
	 * @return [PDO Object] The database connexion
	 */
	private function getDb() {
		return $this->db;
	}

	/**
	 * Set [PDO Object] Instance
	 * Please do not use !
	 * @param [PDO Object] $db The database connexion
	 */
	private function setDb($db) {
		$this->db = $db;
	}

	/**
	 * Get the database host name
	 * @return string the data base host name
	 */
	private function getHost() {
		return $this->host;
	}

	/**
	 * 
	 * @param type $host
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	public function getDatabase() {
		return $this->database;
	}

	public function setDatabase($database) {
		$this->database = $database;
	}

	public function getUser() {
		return $this->user;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getTable_name() {
		return $this->table_name;
	}

	public function setTable_name($table_name) {
		$this->table_name = $table_name;
	}

	public function getPrimary_Key() {
		return $this->primary_Key;
	}

	/**
	 * 
	 * @param type $primary_Key
	 */
	public function setPrimay_Key($primary_Key = NULL) {
		$this->primary_Key = $primary_Key;
	}

}
