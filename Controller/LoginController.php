<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 15/01/2016
 * Time: 07:43
 */

use Model\LoginUser;
use Repository\LoginRepository;
use System\MVC\Controller;

class LoginController extends Controller {

    private $loginRepository;
    public function __construct(){
        parent::__construct();

        $this->loginRepository = new LoginRepository();
    }


    public function index(){
        if(isset($_POST["Username"]) && isset($_POST["Password"])){
             $loginUser = new LoginUser();
             $loginUser->MapParameters($_POST);
             $checkLogin = $this->loginRepository->CheckLogin($loginUser);
             $loginUser->MapParameters($checkLogin);
             if($loginUser->Id){
                $_SESSION["userName"]= $loginUser->Username;
                $_SESSION["userType"] = $loginUser->Usertype;
                $this->Redirect("Home");
             }
            else
            {
                $status = 0;
                $this->Redirect("Login?status=$status");
            }
        }
        else {
            $this->view->render("Login/Index");
        }
    }


}