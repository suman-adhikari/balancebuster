<?php

use Model\ExpenseName;
use Model\Expenses;
use Repository\ExpenseNameRepository;
use System\MVC\Controller;
use Repository\ExpensesRepository;
use Shared\Conformation\ConformationSet;
use Shared\AjaxGrid\AjaxModel;

class HomeController extends Controller {

    private $expensesRepository;
    private $expenseNameRepository;

    public function __construct(){
        parent::__construct();
        $this->expensesRepository = new ExpensesRepository();
        $this->expenseNameRepository = new ExpenseNameRepository();
    }

    public function index(){
        $this->view->render("Home/Index");
    }

    public function Form(){
        $expenses = new Expenses();
      if(isset($_GET["ID"]) && $_GET["ID"]>0 ){
          $data =  $this->expensesRepository->GetById($_GET["ID"]);
          $expenses->MapParameters($data[0]);
        }
        $expenseName = $this->expenseNameRepository->FindAllName();
        $params["expenseName"] = $expenseName;
        $params["expense"] = $expenses;  // assoiciative array
        $this->view->render("Home/Form",$params);
    }

    public function SaveUpdate(){

        $expenses = new Expenses();
        $expenses->MapParameters($_POST);
        if($expenses->Id >0){
            $status = $this->expensesRepository->Update($expenses);
            ConformationSet::Update($status);
        }
        else
        {

            $status =$this->expensesRepository->Save($expenses);
            ConformationSet::Save($status);
        }

        $this->Redirect("Home");

    }

    public function FindAll(){
        $ajaxGrid = new AjaxModel();
        $ajaxGrid->MapParameters($_GET);
        //var_dump($ajaxGrid);
        echo json_encode($this->expensesRepository->FindAll($ajaxGrid));

    }


    public function Delete(){

    $status = $this->expensesRepository->DeleteById($_POST["ID"]);
    ConformationSet::Delete($status);
    $this->Redirect("Home");

    }

}