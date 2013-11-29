<?php

require_once './controller/BaseController.php';

/**
 * The user controller
 * 
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 */
class Error extends BaseController
{

    /**
     * Constructor
     * 
     */
    public function __construct() {
        parent::__construct('');
    }

    /**
     * The controller index
     * Load default view
     */
    public function ErroNo404() {
        $this->twig->display('info/msg.failure.404.twig');
    }

	public function add() {
		
	}

	public function delete($id) {
		//
	}

	public function edit($id) {
		//
	}

	public function index() {
		//
	}

	public function show($id) {
		//
	}
}
