<?php
require_once './Controller/BaseController.php';

/**
 * The project controller
 * 
 * @author Alex Maxime CADEVALL <a.cadevall@insta.fr>
 * @author Alann Dragin <a.dragin@insta.fr>
 */
    class Projects extends BaseController{
    
    /*
     * Constructor
     */

    public function __construct() {
		parent::__construct('ProjectsModel');
		 $this->restrict();
	}
    
    /*
     * The controller index
     * load default view
     */
    
public function index() {
         $this->restrict();
         $this->model->init();
         $projectsList = $this->model->loadAll();
         $data=array('projects'=>$projectsList);
         $this->model->close();
         $this->twig->display('projects/overview.html.twig',$data);
	}
    
    /*
     * Add a  new project into the database
     */

    public function add() {
      
         $this->restrict();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {

            require_once './core/validator.php';
            $validator = Validator::getInstance();
        
             $validator->addRules('name', 'maxlength[45]')
                     ->addRules('createDate', 'required|validdate')
                     ->addRules('deadline', 'required|validdate')
                     ->addRules('company', 'required');
        
                      if ($validator->run()) {
                          $this->model->init();
                          $project=array('idProject'=>'',
                              'name'=>$_POST['name'],
                              'createDate'=>$_POST['createDate'],
                              'deadline'=>$_POST['deadline'],
                              'company'=>$_POST['company']
                                  );
                           if ($this->model->createProject($project))
                           {
                               //succes
                           }
                           else{
                               //die
                           }
                      }
                      
	}
                        $this->twig->display('projects/create.html.twig');
    }

    /*
     * delete an project 
     * params : int $id
     * return : nothing
     */
    
      public function delete($idProject) {
          
       if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)){
        $this->restrict();
        $this->model->init();
       
        if($this->model->deleteByIdProject($idProject)) {
           $msg = 'Le projet numéro : ' . $idProject . ' a bien été effacé';
                $data = array(
                    'action' => 'suppression',
                    'view' => 'projects',
                    'msg' => $msg
                );
                $this->twig->display('info/msg.success.request.twig', $data);
                   $this->model->close();
       }else {
                $msg = "Le projet numéro : " . $idProject . " n'a pas pu être supprimé";
                $data = array(
                    'action' => 'suppression',
                   'view' => 'projects',
                    'msg' => $msg
                );
                 $this->model->close();
                $this->twig->display('info/msg.failure.request.twig', $data);
                  }
            exit;
          }
          
        $this->model->init();
        if ($this->model->loadById($idProject)) {
            $data = array(
                'action' => 'delete',
                'view' => 'projects',
                'id' => $idProject
                    );
            
            $this->twig->display('info/msg.confirmation.request.twig', $data);
             $this->model->close();
        } else {
            $msg = "Le projet numéro : " . $idProject . " n'existe pas";
            $data = array(
                'view' => 'projects',
                'msg' => $msg
            );
            $this->model->close();
            $this->twig->display('info/msg.failure.request.twig', $data);
        }
          
      }
    
    /*
     * Edit a older project
     * params : int  $idProject
     * return : nothing
     */

    public function edit($idProject) {
        
	$this->restrict();
            $this->model->init();
            $project = $this->model->loadById($idProject);
            $data= array(
              'project' => $project);
            
               if (empty($project)) {
                   $this->model->close();
            $this->redirect('/projects');
        }else {
            
         
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST['idProject'] == $idProject) {
            
            require_once './core/validator.php';
            $validator = Validator::getInstance();
            
                 $validator->addRules('name', 'maxlength[45]')
                    ->addRules('deadline', 'required|validdate')
                   ->addRules('company', 'required');
            
             if ($validator->run()) {
                 
                  $data=array('idProject'=>$idProject,
                      'name'=>$_POST['name'],
                      'deadline'=>$_POST['deadline'],
                     'company'=>$_POST['company']
                      );
                  
                    if ($this->model->save($data)) {
                    $this->alert('Projet #' . $idProject . ' modifié', 'success');
             } else {
                    $this->alert('Impossible de sauvegarder les changements', 'danger');
                }
        }
             
             }
             
               $this->model->close();
               $this->twig->display('projects/edit.html.twig',$data);
        }
        
	}

    public function show($idProject) {
        
        $this->restrict();
        $this->model->init();

        $project = $this->model->loadById($idProject);
        $data =  array(
            'project' => $project);
        
        if (empty($project)) {
            $this->model->close();
            $this->redirect('/projects');
        }
        else{
        $this->model->close();
        $this->twig->display('projects/show.html.twig',$data);
        
        }
		
	}
    
   

}
    
