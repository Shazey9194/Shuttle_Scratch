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
        $sql = $this->select(array('idUser', 'email', 'firstname', 'lastname', 'roles', 'state', 'company'))
                ->where(array('email = :email', 'password = :password'))
                ->buildQuery();
        $auth = $this->db->prepare($sql);
        $auth->execute(array(':email' => $email, ':password' => $password));

        return $auth->fetch();
    }

    public function existEmail($email) {

        $sql = $this->select(array('email'))
                ->where(array('email = :email'))
                ->buildQuery();
        $existeEmail = $this->db->prepare($sql);
        $existeEmail->execute(array(':email' => $email));

        return $existeEmail->fetch();
    }

}
