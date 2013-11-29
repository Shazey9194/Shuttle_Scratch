<?php

require_once './Controller/BaseController.php';
require_once './Controller/BaseController.php';

Session::run();

class Dashboard extends BaseController {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('UserModel');
		Session::run();
	}

	/**
	 * The controller index
	 */
	public function index() {
		$this->model->init();
		$idData = Session::getUserData();
		$user = $this->model->loadUserData($idData['idUser']);
		$user['roles'] = json_decode($user['roles']);
		$this->twig->display('dashboard/overview.html.twig', array(
			'userData' => $user
		));
		$this->model->close();
	}

	public function add() {
		//to do
	}

	public function delete($id) {
		//to do
	}

	public function edit($id) {
		//to do
	}

	public function show($id) {
		//to do
	}

}
