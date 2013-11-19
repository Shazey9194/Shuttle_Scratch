<?php

require_once './model/BaseModel.php';

/**
 * The user model
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
class UserModel extends BaseModel
{

    function __construct() {
        parent::__construct('user', 'idUser');
    }

}
