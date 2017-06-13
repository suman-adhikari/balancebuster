<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 09/01/2016
 * Time: 22:45
 */

namespace System\MVC;

use conf\db;

 class Repo {

    public $dbc;

    public function __construct(){
        $this->dbc = new db();
    }

}