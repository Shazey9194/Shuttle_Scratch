<?php

header('Content-type: text/html; charset=UTF-8');

/** Router **/
require_once './core/router.php';
$router = Router::getInstance();
$router->run();
/** End Router **/
