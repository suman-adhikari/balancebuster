<?php
use Repository\DashboardRepository;
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 31/01/2016
 * Time: 12:03
 */

class DashboardController extends Controller {

    private $dashData;
    public function __construct(){
        parent::__construct();
        $this->dashData = new DashboardRepository();
    }

    public function index(){
        $this->view->render("Dashboard/Index");
    }

    public function DashboardData(){
        echo json_encode($this->dashData->DashboardData());
    }

}