<?php

require_once './Controller/BaseController.php';

/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class Dashboard extends BaseController
{

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        Session::run();
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

}
