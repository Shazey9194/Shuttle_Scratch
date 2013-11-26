<?php

require_once './Controller/BaseController.php';

/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class Tickets extends BaseController {
	/*
	 * Constructor
	 */

	public function __construct() {
		parent::__construct("TicketsModel");
		Session::run();
		$this->model->init();
	}

	/*
	 * index view
	 */

	public function index() {
		$this->twig->display('tickets/overview.html.twig');
	}

	/*
	 * create view
	 */

	public function create() {
		$data = array(
            'types' => $this->model->loadTicketTypes()
        );
		$this->twig->display('tickets/create.html.twig', $data);
	}

	/*
	 * show view
	 */

	public function show($idTicket) {
		$this->twig->display('tickets/show.html.twig');
	}

	/*
	 * add view
	 */

	public function add() {
		//do something
	}

	/*
	 * delete view
	 */

	public function delete($idTicket) {
		//do something
	}

	/*
	 * edit view
	 */

	public function edit($idTicket) {
		//do something
	}

}
