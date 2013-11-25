<?php

require_once './model/BaseModel.php';

/**
 * The user model
 * 
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class UserModel extends BaseModel
{

    function __construct() {
        parent::__construct('user', 'idUser');
    }
    
}
