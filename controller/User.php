<?php

require_once './Controller/BaseController.php';

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
        parent::__construct();
    }

    /**
     * The controller index
     * 
     */
    public function index() {

        $this->twig->display('user/users.html.twig');
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

                $email = HTML_SPECIALCHARS($_POST['email']);
                $password = HTML_SPECIALCHARS($_POST['password'] . $_POST['email']);

                if (TRUE) { // test authentification !
                    // open session
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

        $user = $this->model->loadById($idUser);

        $this->twig->display('user/show.html.twig', array('user' => $user));
    }

    /**
     * Edit an user from its id
     * 
     * @param int $idUser The usr id
     */
    public function edit($idUser) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('firstname', 'maxlength[45]')
                    ->addRules('lastname', 'maxlength[45]');

            if ($validator->run()) {

                $data = array(); // donnees utilisateur

                if (TRUE) { // sauvegarde utilisateur
                    //success
                } else {
                    //erreur
                }
            }
        }

        $user = $this->model->loadById($idUser);

        $this->twig->display('user/edit.html.twig', array('user' => $user));
    }

    /**
     * Delete an user from its id
     * 
     * @param int $idUser The entity id
     */
    public function delete($idUser) {
        return $this->model->deleteById($idUser);
    }

    public function add() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('firstname', 'maxlength[45]')
                    ->addRules('lastname', 'maxlength[45]')
                    ->addRules('email', 'required|email|maxlenght[255]');

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

    public function logout() {

        $this->user->logout();
        redirect('login');
    }

    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('email', 'required|email|maxlenght[255]')
                    ->addRules('password', 'required|maxlength[24]')
                    ->addRules('confirm', 'match[password]');

            if ($validator->run()) {

                if (!$this->model->uniqueEmail($_POST['email'])) {
                    
                    $validator->addCustomError('uniqueEmail', 'Cet adresse email est déjà utilisée');
                    
                } else {

                    $data = array(); // donnees utilisateur

                    if (TRUE) { // sauvegarde utilisateur
                        //success
                    } else {
                        //erreur
                    }
                }
            }
        }

        $this->twig->display('user/register.html.twig');
    }

}