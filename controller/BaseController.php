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
        $this->twig = new Twig_Environment($loader, array('cache' => './cache/twig'));

        $set_value = new Twig_SimpleFunction('set_value', function ($name, $value, $default = null) {
                    if (isset($_POST[$name]) and $_POST[$name] == $value) {
                        echo 'value="' . $_POST[$name] . '"';
                    } elseif (!is_null($default)) {
                        echo 'value="' . $default . '"';
                    }
                });
        $this->twig->addFunction($set_value);
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