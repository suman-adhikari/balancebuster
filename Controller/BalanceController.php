<?php
use Repository\BalanceRepository;
use Shared\AjaxGrid\AjaxModel;
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 5/29/2017
 * Time: 8:21 AM
 */

class BalanceController extends Controller {

    private $balanceRepository;
    public function __construct(){
        parent::__construct();
        $this->balanceRepository = new BalanceRepository();
    }

    public function index(){
      $this->view->render("Balance/index");
    }

    public function FindAll(){
        $ajaxGrid = new AjaxModel();
        $ajaxGrid->MapParameters($_GET);
        echo json_encode($this->balanceRepository->FindAll($ajaxGrid));
    }

}