<?php
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 5/29/2017
 * Time: 7:18 AM
 */

class LogoutController extends Controller {

   function __construct(){
       parent::__construct();
   }


   public function index(){
       //session_start();
       session_destroy();
       $this->Redirect("Login");

   }
}