<?php

require_once './Controller/BaseController.php';

/**
 * The dasboard controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 */
class Tickets extends BaseController
{
    /*
     * Constructor
     */

    public function __construct() {
        parent::__construct("TicketsModel");
        $this->session->restrict();
    }

    /*
     * index view
     */

    public function index() {
        $this->model->init();
        $ticketList = $this->model->loadAllTickets();
        $data = array(
            'ticketList' => $ticketList,
                //'showdebug' => true,
                //'dumps' => $ticketList,
        );
        $this->model->close();
        $this->twig->display('tickets/overview.html.twig', $data);
    }

    /*
     * create view
     */

    public function create() {
        /* if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
          /* require_once './core/validator.php';
          $validator = Validator::getInstance();

          $validator->addRules('title', 'required|title')
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
          $data = array(
          'name' => 'tickets',
          'msg' => 'msg test',
          'showdebug' => true,
          'dumps' => $_POST
          );
          $this->twig->display('info/msg.success.request.twig', $data);
          exit;
          } */
        $data = array(
                //'types' => $types,
                //'showdebug' => true,
                //'dumps' => $teams,
                //'projets' => $projets,
                //'teams' => $teams
        );
        $this->twig->display('tickets/create.html.twig', $data);
    }

    /*
     * show view
     */

    public function show($idTicket) {
        $this->model->init();
        $tickeData = $this->model->loadById($idTicket);
        $data = array(
            'ticket' => $tickeData,
                //'showdebug' => true,
                //'dumps' => $tickeData,
        );
        $this->model->close();
        $this->twig->display('tickets/show.html.twig', $data);
    }

    /*
     * add view
     */

    public function add() {
        //do something
    }

    /*
     * delete view
     */

    public function delete($idTicket) {
        $this->model->init();
        //$tickeData = $this->model->loadById($idTicket);
        //$this->model->close();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
            if ($this->model->deleteById($idTicket)) {
                $msg = 'Le ticket numéros : ' . $idTicket . ' a bien été effacé';
                $data = array(
                    'action' => 'suppression',
                    'view' => 'tickets',
                    'msg' => $msg
                );
                $this->twig->display('info/msg.success.request.twig', $data);
            } else {
                $msg = "Le ticket numéros : " . $idTicket . " n'a pas,pu être supprimé";
                $data = array(
                    'action' => 'suppression',
                    'view' => 'tickets',
                    'msg' => $msg
                );
                $this->twig->display('info/msg.failure.request.twig', $data);
            }
            exit;
        }
        $data = array(
            'action' => 'supprimer',
            'view' => 'tickets',
            'id' => $idTicket,
                //	'showdebug' => true,
                //	'dumps' => $tickeData,
        );
        $this->twig->display('info/msg.confirmation.request.twig', $data);
    }

    /*
     * edit view
     */

    public function edit($idTicket) {
        //do something
    }

}
