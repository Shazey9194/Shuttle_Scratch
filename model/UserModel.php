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

    /**
     * 
     */
    public function __construct() {
        parent::__construct('user', 'idUser');
    }
    
    /**
     * 
     * @param type $login
     * @param type $password
     */
    public function authentificate($email, $password) {
        $sql = $this->select()
                ->where(array('email = :email', 'password = :password'))
                ->buildQuery();
        $auth = $this->db->prepare($sql);
        $auth->execute(array(':email' => $email, ':password' => $password));
        
        return $auth->fetch();
    }
    
}
