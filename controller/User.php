<?php

require_once './Controller/BaseController.php';

/**
 * The user controller
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
class User extends BaseController
{

    /**
     * Construct
     * 
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * The controller index
     * 
     */
    public function index() {
        
    }

    /**
     * The user login action
     * 
     */
    public function login() {
        $this->twig->display('user/login.html.twig');
    }

    /**
     * Add an user
     * 
     */
    public function add() {
        
    }

    /**
     * Display an user from its id
     * 
     * @param int $idUser The user id
     */
    public function show($idUser) {
        
    }

    /**
     * Edit an user from its id
     * 
     * @param int $idUser The usr id
     */
    public function edit($idUser) {
        
    }

    /**
     * Delete an user from its id
     * 
     * @param int $idUser The entity id
     */
    public function delete($idUser) {
        
    }

}