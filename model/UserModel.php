<?php

require_once './model/BaseModel.php';

/**
 * The user model
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr> && Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class UserModel extends BaseModel {

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

	public function authentification($email, $password) {
		$currentSession = Session::getInstance();
		$statement = "SELECT idUser, password, email FROM user WHERE email=".$this->db->quote($email)." AND password=".$this->db->quote($password);
		$result = $this->db->query($statement);
		if ($result->rowCount()) {
			$bind = $result->fetch();
			$arrayData = array("idUser","email","lastname","firstname","roles","registerDate","lastLoginDate","state","company");
			$data = $this->loadById($bind['idUser'],$arrayData);
			if(sizeof($data) < 3 || empty($data)){
				$state = FALSE;
			} else {
				$currentSession->startUserSession($data);
				$state = TRUE;
			}
		}  else {
			$state = FALSE;
		}
		return $state;
	}
	public function deleteData() {
		$currentSession = Session::getInstance();
		$currentSession->endUserSession();
	}

}
