<?php require_once './library/Twig/Autoloader.php';

/**
 * The base controller
 * 
 * @author Fabien Morchoisne <f.morchoisne@insta.fr>
 */
abstract class BaseController
{

    /**
     * Construct
     * 
     */
    function __construct() {
        Twig_Autoloader::register();
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