<?php

require_once './controller/BaseController.php';

/**
 * The user controller
 * 
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 */
class User extends BaseController
{

    /**
     * Construct
     * 
     */
    public function __construct() {
        parent::__construct('UserModel');
    }

    /**
     * The controller index
     * 
     */
    public function index() {

        Session::run();

        $this->model->init();

        $this->twig->display('user/users.html.twig', array(
            'users' => $this->model->loadAll()
        ));

        $this->model->close();
    }

    /**
     * The user login action
     * 
     */
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('email', 'required|email')
                    ->addRules('password', 'required');

            if ($validator->run()) {

                $email = strtolower($_POST['email']);
                $password = md5($_POST['password'] . $email);

                $this->model->init();
                if (($user = $this->model->authentificate($email, $password)) != FALSE) {

                    $user['roles'] = json_decode($user['roles']);

                    Session::startUserSession($user);

                    $this->redirect('/dashboard');
                }

                $validator->addCustomError('badCredentials', 'Identifiants incorrects');
            }
        }



        $this->twig->display('user/login.html.twig');
    }

    /**
     * Display an user from its id
     * 
     * @param int $idUser The user id
     */
    public function show($idUser) {

        Session::run();

        $this->model->init();

        $user = $this->model->loadById($idUser);
        if (empty($user)) {
            $this->redirect('/user');
        }

        $this->twig->display('user/show.html.twig', array(
            'user' => $user
        ));

        $this->model->close();
    }

    /**
     * Edit an user from its id
     * 
     * @param int $idUser The usr id
     */
    public function edit($idUser) {

        Session::run();

        $this->model->init();

        $user = $this->model->loadById($idUser);
        if (empty($user)) {
            $this->redirect('/user');
        }

        // test d'égalité uri<->form pour plus de sécurité
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idUser'] == $idUser) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('firstname', 'maxlength[45]')
                    ->addRules('lastname', 'maxlength[45]');

            if ($validator->run()) {

                $data = array(
                    'idUser' => $idUser,
                    'firstname' => ucwords(strtolower($_POST['firstname'])),
                    'lastname' => strtoupper($_POST['lastname']),
                    'roles' => json_encode($_POST['roles']),
                );

                if ($this->model->save($data)) { // sauvegarde utilisateur
                    //success
                } else {
                    //erreur
                }
            }
        }

        $this->twig->display('user/edit.html.twig', array(
            'user' => $user
        ));

        $this->model->close();
    }

    /**
     * Delete an user from its id
     * 
     * @param int $idUser The entity id
     */
    public function delete($idUser) {
        Session::run();
        return $this->model->deleteById($idUser);
    }

    /**
     * 
     */
    public function add() {

        Session::run();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('firstname', 'maxlength[45]')
                    ->addRules('lastname', 'maxlength[45]')
                    ->addRules('email', 'required|email|maxlength[255]');

            if ($validator->run()) {

                $data = array(); // donnees utilisateur

                if (TRUE) { // sauvegarde utilisateur
                    //success
                } else {
                    //erreur
                }
            }
        }

        $this->twig->display('user/create.html.twig');
    }

    /**
     * 
     */
    public function logout() {

        Session::endUserSession();

        $this->redirect('/login');
    }

    /**
     * 
     */
    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('email', 'required|email|maxlength[255]|uniqueEmail')
                    ->addRules('password', 'required|maxlength[24]')
                    ->addRules('confirm', 'match[password]');

            if ($validator->run()) {

                $email = strtolower($_POST['email']);
                $password = md5($_POST['password'] . $email);

                $this->model->init();

                $data = array(
                    'email' => $email,
                    'password' => $password
                );

                if ($this->model->save($data)) { // sauvegarde utilisateur
                    //success
                } else {
                    //erreur
                }
                die;
            }
        }

        $this->twig->display('user/register.html.twig');
    }

}
