<?php

require_once './core/validator.php';
$validator = new Validator();

$validator->addRules('email', array(
            'required' => true,
            'max_lenght' => 50,
            'filter' => 'email'
        ))
        ->addRules('firstname', array(
            'required' => false,
            'max_lenght' => 50
        ));

$validator->run();





/*
require_once './core/router.php';
$router = new Router('/Shuttle_Scratch/');

$router->run();*/