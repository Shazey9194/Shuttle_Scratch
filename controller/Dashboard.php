<?php

require_once './Controller/BaseController.php';

/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
<<<<<<< HEAD
class Dashboard extends BaseController
{

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->restrict();
    }

    /**
     * The controller index
     */
    public function index() {
        $this->twig->display('dashboard/overview.html.twig', array(
            'session' => $_SESSION
        ));
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
=======
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
>>>>>>> bd14fcb1dfea292273f73a30bd5d3d024e69af83

}
