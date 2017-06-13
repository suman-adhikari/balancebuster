<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 09/01/2016
 * Time: 22:44
 */

namespace System\MVC;


class Controller {

    public $view;
    public $somerepo;

    public function __construct(){

        $this->view = new View();
        $this->somerepo = new Repo();
    }

    function Redirect($uri,$httpResponseCode = 302)
    {

        if (!preg_match('#^https?://#i', $uri)) {
            $uri = BASE_URL . $uri;
            header("Location: " . $uri, TRUE, $httpResponseCode);
            die();
        }
    }


}