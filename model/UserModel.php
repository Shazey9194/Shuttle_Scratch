<?php

require_once './model/BaseModel.php';

/**
 * The user model
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr> && Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class UserModel extends BaseModel
{
	private $userdata;
	
    function __construct() {
        parent::__construct('user', 'idUser');
    }
	
	public function getUserdata() {
		return $this->userdata;
	}

	public function setUserdata($userdata) {
		$this->userdata = $userdata;
	}
	
	public function close() {
		parent::close();
	}

	public function deleteById($id) {
		parent::deleteById($id);
	}

	public function getDatabase() {
		return parent::getDatabase();
	}

	public function getDb() {
		return parent::getDb();
	}

	public function getHost() {
		return parent::getHost();
	}

	public function getPassword() {
		return parent::getPassword();
	}

	public function getPrimary_Key() {
		return parent::getPrimary_Key();
	}

	public function getTable_name() {
		return parent::getTable_name();
	}

	public function getUser() {
		return parent::getUser();
	}

	public function init() {
		parent::init();
	}

	public function insertData($data) {
		parent::insertData($data);
	}

	public function loadAll($offset = 0, $limit = 0) {
		return parent::loadAll($offset, $limit);
	}

	public function loadById($id) {
		return parent::loadById($id);
	}

	public function save($data) {
		parent::save($data);
	}

	public function setDatabase($database) {
		parent::setDatabase($database);
	}

	public function setDb($db) {
		parent::setDb($db);
	}

	public function setHost($host) {
		parent::setHost($host);
	}

	public function setPassword($password) {
		parent::setPassword($password);
	}

	public function setPrimary_Key($primary_Key) {
		parent::setPrimary_Key($primary_Key);
	}

	public function setTable_name($table_name) {
		parent::setTable_name($table_name);
	}

	public function setUser($user) {
		parent::setUser($user);
	}

	public function updateFields($id, $data) {
		parent::updateFields($id, $data);
	}

}
