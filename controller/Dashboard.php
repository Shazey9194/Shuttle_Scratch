<?php
/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */

require_once './Controller/BaseController.php';
Session::run();

class Dashboard extends BaseController
{

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * The controller index
     */
    public function index() {
		$sessionData = Session::getInstance();
		$sessionData = $sessionData->getData();
        $this->twig->display('dashboard/overview.html.twig', array('session' => $sessionData));
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
