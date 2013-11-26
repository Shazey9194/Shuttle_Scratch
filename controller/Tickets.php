<?php
/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */

require_once './Controller/BaseController.php';
Session::run();

class Tickets extends BaseController{

	/*
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('TicketsModel');
	}

	/**
     * The controller index
     * Load default view
     */
	 public function index() {
		 $this->twig->display('tickets/overview.html.twig');
	 }
	 
	/*
	 * create view
	 */
	public function create(){
		$this->twig->display('tickets/create.html.twig');
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