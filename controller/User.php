<?php

require_once './Controller/BaseController.php';

/**
 * The user controller
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
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
        /* $this->twig->display('user/users.html.twig', array(
          'users' => $this->user->loadAll()
          )); */
        $this->twig->display('user/users.html.twig');
    }

    /**
     * The user login action
     * 
     */
    public function login() {
        /*
          if ($this->user->isLogged()) {
          return redirect('dashboard');
          }

          $this->checkUserAgent();

          $data = array();

          if ($this->input->server('REQUEST_METHOD') == 'POST') {

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<div class="input-error">', '</div>');

          $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email');
          $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required');

          if ($this->form_validation->run()) {

          $email = $this->input->post('email');
          $password = md5($this->input->post('password') . $this->input->post('email'));

          if ($this->user->authentification($email, $password)) {
          redirect('dashboard');
          } else {
          $data['error'] = 'Identifiants incorrects';
          }
          }
          } */

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
            require_once './core/validator.php';
            $validator = Validator::getInstance();

            
            
            
            
            $validator->addRules('email', 'required|email')
                    ->addRules('password', 'required');

            
            
            
            
            if ($validator->run()) {
                
                
                
                $validator->addCustomError('badCredentials', 'Identifiants incorrects');
            }
        }


        $this->twig->display('user/login.html.twig');
    }

    /**
     * Add an user
     * 
     */
    public function add() {
        
    }

    /**
     * Display an user from its id
     * 
     * @param int $idUser The user id
     */
    public function show($idUser) {
        $this->twig->display('user/show.html.twig');
    }

    /**
     * Edit an user from its id
     * 
     * @param int $idUser The usr id
     */
    public function edit($idUser) {
        /* if ($this->input->server('REQUEST_METHOD') == 'POST') {

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<div class="input-error">', '</div>');

          //$this->form_validation->set_rules('company', 'Société', 'trim|required|strtolower|max_length[255]');
          //$this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_uniqueEmail');
          $this->form_validation->set_rules('firstname', 'Prenom', 'max_length[45]');
          $this->form_validation->set_rules('lastname', 'Nom', 'max_length[45]');
          $this->form_validation->set_rules('roles[]', 'Roles', '');

          if ($this->form_validation->run()) {

          $data = array(
          'idUser' => $idUser,
          'company' => $this->input->post('company'),
          'firstname' => $this->input->post('firstname'),
          'lastname' => $this->input->post('lastname'),
          'roles' => json_encode($this->input->post('roles'))
          );

          if ($this->user->save($data)) {
          echo 'sauvegardé';
          return true;
          } else {
          echo 'erreur à la sauvegarde';
          return false;
          }
          }
          } */

        $this->twig->display('user/edit.html.twig');
    }

    /**
     * Delete an user from its id
     * 
     * @param int $idUser The entity id
     */
    public function delete($idUser) {
        
    }

    public function create() {
        /*
          if ($this->input->server('REQUEST_METHOD') == 'POST') {

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<div class="input-error">', '</div>');

          //$this->form_validation->set_rules('company', 'Société', 'trim|required|strtolower|max_length[255]');
          $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_uniqueEmail');
          $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required');
          $this->form_validation->set_rules('confirmation', 'Confirmation', 'required|matches[password]');
          $this->form_validation->set_rules('firstname', 'Prenom', 'max_length[45]');
          $this->form_validation->set_rules('lastname', 'Nom', 'max_length[45]');

          if ($this->form_validation->run()) {

          $now = new \DateTime();
          $data = array(
          'company' => $this->input->post('company'),
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password')),
          'registerDate' => $now->format('Y-m-d H:i:s'),
          'firstname' => $this->input->post('firstname'),
          'lastname' => $this->input->post('lastname')
          );

          if ($this->user->save($data)) {
          echo 'enregistré';
          return true;
          } else {
          echo 'erreur à l\'enregistrement';
          return false;
          }
          }
          }
         */
        $this->twig->display('user/create.html.twig');
    }

    public function logout() {

        $this->user->logout();
        redirect('login');
    }

    public function register() {

        /* if ($this->input->server('REQUEST_METHOD') == 'POST') {

          $this->load->library('form_validation');
          $this->form_validation->set_error_delimiters('<div class="input-error">', '</div>');

          //$this->form_validation->set_rules('company', 'Société', 'trim|required|strtolower|max_length[255]');
          $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_uniqueEmail');
          $this->form_validation->set_rules('password', 'Mot de passe', 'trim|required');
          $this->form_validation->set_rules('confirmation', 'Confirmation', 'required|matches[password]');

          if ($this->form_validation->run()) {

          $now = new \DateTime();
          $data = array(
          //'company' => $this->input->post('company'),
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password') . $this->input->post('email')),
          'registerDate' => $now->format('Y-m-d H:i:s'),
          );

          if ($this->user->save($data)) {
          echo 'enregistré';
          return true;
          } else {
          echo 'erreur à l\'enregistrement';
          return false;
          }
          }
          }
         */
        $this->twig->display('user/register.html.twig');
    }

    public function checkUserAgent() {
        /*
          $this->load->library('user_agent');
          if ($this->agent->is_browser('Internet Explorer') OR $this->agent->is_browser('MSIE')) {
          $this->load->helper('url');
          $this->twig->display('user/browsers.html.twig');
          die;
          }
         * 
         */
    }

    public function uniqueEmail($email) {
        /*
          $this->form_validation->set_message('uniqueEmail', 'Un compte existe déjà pour cet Email');
          return $this->user->isUniqueEmail($email); */
    }

}