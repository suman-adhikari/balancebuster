<?php
use Repository\DetailedStatisticsRepository;
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 26/11/2016
 * Time: 18:54
 */

class DetailedStatisticsController extends Controller
{

    private $detailedStats;

    function __construct()
    {
        parent::__construct();

        $this->detailedStats = new DetailedStatisticsRepository();
    }

    public function Index()
    {

        $data = $this->detailedStats->GetExpenseType();
        $param["expenseType"] = $data;
        $this->view->render("DetailedStatistics/Index", $param);
    }

    public function GetAll(){
        $interval = $_GET["Interval"];
        $expenseType = $_GET["ExpenseId"];
        $dateFrom = $_GET["DateFrom"];
        $dateTo = $_GET["DateTo"];

        echo json_encode($this->detailedStats->GetAll($interval, $expenseType,$dateFrom,$dateTo));
    }

}