<?php

require_once './vendor/twig/Autoloader.php';

/**
 * The base controller
 * 
 * @author Fabien MORCHOISNE <f.morchoisne@insta.fr>
 */
abstract class BaseController
{

    /**
     * The twig environment
     * 
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * The main controller model
     *
     * @var \BaseModel
     */
    protected $model = null;

    /**
     * Construct
     * 
     */
    protected function __construct($model = null) {

        if (null != $model) {
            require_once './model/' . $model . '.php';
            $this->model = new $model();
        }

        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('./view');
        $this->twig = new Twig_Environment($loader);

        $this->extend();
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

    /**
     * 
     * @param type $request
     */
    protected function redirect($request) {
        header('location: .' . $request);
        exit;
    }

    /**
     * 
     * @return void
     */
    private function extend() {
        $functions[] = new Twig_SimpleFunction('setValue', function ($input, $default = null) {
                    if (isset($_POST[$input])) {
                        echo 'value="' . $_POST[$input] . '"';
                    } elseif (!is_null($default)) {
                        echo 'value="' . $default . '"';
                    }
                });

        $functions[] = new Twig_SimpleFunction('domain', function () {
                    echo 'http://' . $_SERVER['SERVER_NAME'] . '/';
                });

        $functions[] = new Twig_SimpleFunction('formError', function ($field, $html = true) {
                    if (class_exists('Validator')) {
                        $validator = Validator::getInstance();
                        if (($message = $validator->getError($field)) != FALSE) {
                            if ($html) {
                                echo '<div class="input-error">' . $message . '</div>';
                            } else {
                                echo $message;
                            }
                        }
                    }
                });

        $functions[] = new Twig_SimpleFunction('hasError', function ($field) {
                    if (class_exists('Validator')) {
                        $validator = Validator::getInstance();
                        return $validator->hasError($field);
                    }
                });

        $functions[] = new Twig_SimpleFunction('set_select', function($select, $value, $default = false) {
                    if ((isset($_POST[$select]) and $_POST[$select] == $value) or $default) {
                        echo 'selected="selected"';
                    }
                });

        $functions[] = new Twig_SimpleFunction('isGranted', function() {
                    return FALSE;
                });

        foreach ($functions as $function) {
            $this->twig->addFunction($function);
        }
    }

}