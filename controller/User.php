<?php

require_once './Controller/BaseController.php';

class User extends BaseController
{

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        echo' hello';
    }

    public function edit($idUser) {
        
        echo 'editing user '. $idUser;
    }

}