<?php

require_once './vendor/twig/Autoloader.php';

/**
 * The base controller
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
abstract class BaseController
{

    /**
     *
     * @var \Twig_Environment The twig environment
     */
    protected $twig;
    
    /**
     * Construct
     * 
     */
    function __construct() {
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('./view');
        $this->twig = new Twig_Environment($loader);

        $set_value = new Twig_SimpleFunction('set_value', function ($name, $default = null) {
                    if (isset($_POST[$name])) {
                        echo 'value="' . $_POST[$name] . '"';
                    } elseif (!is_null($default)) {
                        echo 'value="' . $default . '"';
                    }
                });
        $this->twig->addFunction($set_value);
		
		$base_url = new Twig_SimpleFunction('base_url', function () {
                    return Router::$base_url;
                });
        $this->twig->addFunction($base_url);
		
		$form_error = new Twig_SimpleFunction('form_error', function () {
                    return false;
                });
		$this->twig->addFunction($form_error);
		
		$set_select = new Twig_SimpleFunction('set_select', function(){
			return FALSE;
		});
		$this->twig->addFunction($set_select);
		
		$isGranted= new Twig_SimpleFunction('isGranted', function(){
			return FALSE;
		});
		$this->twig->addFunction($isGranted);
	}

    /**
     * The controller index
     * 
     */
    abstract public function index();

    /**
     * Add an entity
     * 
     */
    abstract public function add();

    /**
     * Display an entity from its id
     * 
     * @param int $id The entity id
     */
    abstract public function show($id);

    /**
     * Edit an entity from its id
     * 
     * @param int $id The entity id
     */
    abstract public function edit($id);

    /**
     * Delete an entity from its id
     * 
     * @param int $id The entity id
     */
    abstract public function delete($id);
}