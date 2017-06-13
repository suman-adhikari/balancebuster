<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 09/01/2016
 * Time: 22:45
 */

namespace conf;
use PDO;

class db {

    public function con(){
        $db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE,USER,PASS);
        return $db;
    }

}