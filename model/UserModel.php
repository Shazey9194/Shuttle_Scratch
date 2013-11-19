<?php

require_once './model/BaseModel.php';

class UserModel extends BaseModel
{
    function __construct() {
        parent::__construct();
        $this->setTable_name('user');
        $this->setPrimary_Key('iduser');
    }
    
}
