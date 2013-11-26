<?php
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

                    //open session with param $user

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

        $this->model->init();

        $this->twig->display('user/show.html.twig', array(
            'user' => $this->model->loadById($idUser)
        ));

        $this->model->close();
    }

    /**
     * Edit an user from its id
     * 
     * @param int $idUser The usr id
     */
    public function edit($idUser) {

        $this->model->init();

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
                
                var_dump($data);
                $this->model->save($data);

                if (TRUE) { // sauvegarde utilisateur
                    //success
                } else {
                    //erreur
                }
            }
        }

        $this->twig->display('user/edit.html.twig', array(
            'user' => $this->model->loadById($idUser)
        ));

        $this->model->close();
    }

    /**
     * Delete an user from its id
     * 
     * @param int $idUser The entity id
     */
    public function delete($idUser) {
        return $this->model->deleteById($idUser);
    }

    /**
     * 
     */
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

    /**
     * 
     */
    public function logout() {


        // close session here
        // $this->user->logout();


        $this->redirect('/login');
    }

    /**
     * 
     */
    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('email', 'required|email|maxlenght[255]')
                    ->addRules('password', 'required|maxlength[24]')
                    ->addRules('confirm', 'match[password]');

            if ($validator->run()) {

                $email = strtolower($_POST['email']);
                $password = md5($_POST['password'] . $email);

                if (!$this->model->uniqueEmail($email)) {

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
