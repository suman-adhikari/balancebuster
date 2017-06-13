<?php
/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 5/29/2017
 * Time: 6:54 AM
 */

namespace Repository;


use Model\LoginUser;
use System\MVC\Repo;

class LoginRepository extends Repo {

    function __construct(){
        parent::__construct();

    }

    public function CheckLogin(LoginUser $loginUser){
        $sql = "select * from LoginUser where username = '$loginUser->Username' and password= '$loginUser->Password'";
        $conn = $this->dbc->con();
        $qry = $conn->prepare($sql);
        $qry->execute();
        $result = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $result[0];
    }
}