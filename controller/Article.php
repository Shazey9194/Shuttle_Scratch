<?php

require_once './Controller/BaseController.php';

class Article extends BaseController
{

    function __construct() {
        parent::__construct();
    }

    public function read($idArtile, $title, $page) {

        echo 'reading page ' . $page . ' of article #' . $idArtile . ' - ' . $title;
    }

}