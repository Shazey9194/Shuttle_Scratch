<?php

header('Content-type: text/html; charset=UTF-8');

/** Session **/
require_once './core/session.php';
Session::start();
/** End Session **/

/** Router * */
require_once './core/router.php';
$router = Router::getInstance();
$router->run();
/**End Router **/