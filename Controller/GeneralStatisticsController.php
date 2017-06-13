<?php
use Repository\GeneralStatisticsRepository;
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 13/02/2016
 * Time: 08:09
 */

class GeneralStatisticsController extends Controller {

    private $allExpenses;
    function __construct(){
        parent::__construct();

        $this->allExpenses = new GeneralStatisticsRepository();
    }

    public function Index(){

        $data = $this->allExpenses->AllData("Today");
        $this->view->render("GeneralStatistics/index",$data);
    }

    public function GetAll(){
         $dateOpt = $_GET["opt"];
       // var_dump($dateOpt);exit;
        echo json_encode($this->allExpenses->AllData($dateOpt));
    }

}