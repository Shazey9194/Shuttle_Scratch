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
     * Constructor
     * 
     */
    public function __construct() {
        parent::__construct('UserModel');
    }

    /**
     * The controller index
     * Load default view
     */
    public function index() {

        $this->restrict();
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

                    if ($user['state'] == 1) {

                        $user['roles'] = json_decode($user['roles']);

                        $this->session->startUserSession($user);

                        $this->model->close();
                        $this->redirect('/dashboard');
                        
                    } elseif ($user['state'] == 0) {
                        $validator->addCustomError('credentials', 'Accèder à votre boîte mail pour activer ce compte');
                        
                    } elseif ($user['state'] >= 2) {
                        $validator->addCustomError('credentials', 'Ce compte n\'est plus autorisé à se connecter');
                        
                    }
                } else {
                    $validator->addCustomError('credentials', 'Identifiants incorrects');
                }
            }
        }

        $this->twig->display('user/login.html.twig');

        $this->model->close();
    }

    /**
     * Display an user from its id
     * 
     * @param int $idUser The user id
     */
    public function show($idUser) {

        $this->restrict();
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

        $this->restrict('admin');

//        $userdata = $this->session->getUserData();
//        if($idUser == $userdata['idUser']) {
//            $this->alert('Vous modifiez votre propre compte !', 'warning');
//        }

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

                if ($this->model->save($data)) {
                    $this->alert('Utilisateur #' . $idUser . ' modifié', 'success');
                } else {
                    $this->alert('Impossible de sauvegarder les changements', 'danger');
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
<<<<<<< HEAD

        $this->restrict();
        $this->model->init();
        $this->model->deleteById($idUser);
        $this->model->close();
        $this->redirect('/user');
=======
        Session::run();
		$this->model->init();
        return true;//$this->model->deleteById($idUser);
		$this->model->close();
>>>>>>> bd14fcb1dfea292273f73a30bd5d3d024e69af83
    }

    /**
     * 
     */
    public function add() {

        $this->restrict();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();

            $validator->addRules('firstname', 'maxlength[45]')
                    ->addRules('lastname', 'maxlength[45]')
                    ->addRules('email', 'required|email|maxlength[255]');

            if ($validator->run()) {

                $data = array(
                    'email' => ucwords(strtolower($_POST['email'])),
                    'password' => $this->generatePassword(),
                    'firstname' => ucwords(strtolower($_POST['firstname'])),
                    'lastname' => strtoupper($_POST['lastname']),
                    'roles' => json_encode($_POST['roles']),
                    'company' => $_POST['company']
                );

                if ($this->model->save($data)) {
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

        $this->session->endUserSession();

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
                $token = md5(uniqid($email));

                $this->model->init();

                $user = array(
                    'email' => $email,
                    'password' => $password,
                    'token' => $token
                );

                if ($this->model->save($user)) {

                    require_once './core/mailer.php';
                    $mailer = new Mailer();
                    $mailer->mailRegister($email, $token, $this->twig);

                    $this->twig->display('info/registerSuccess.html.twig', array(
                        'email' => $email
                    ));
                } else {
                    $this->twig->display('info/registerFailure.html.twig');
                }

                exit;
            }
        }

        $this->twig->display('user/register.html.twig');
    }

    /**
     * 
     * @param type $email
     * @param type $token
     */
    public function activate($email, $token) {
        $this->model->init();
        
        if($this->model->activate($email, $token)) {
            
            $this->twig->display('info/msg.success.request.twig', array(
                'view' => 'login',
                'msg' => 'Votre compte a bien été activé.'
            ));
            
        } else {
            
            $this->twig->display('info/msg.failure.request.twig', array(
                'view' => 'login',
                'msg' => 'Impossible d\'activer ce compte.'
            ));
            
        }
        
        $this->model->close();
    }

}
