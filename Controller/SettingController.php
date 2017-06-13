<?php
use Model\ExpenseName;
use Repository\ExpenseNameRepository;
use Shared\AjaxGrid\AjaxModel;
use System\MVC\Controller;


class SettingController extends Controller {

    public $expenseNameRepository;
    public function __construct(){
        parent::__construct();
        $this->expenseNameRepository = new ExpenseNameRepository();
    }

    public function index(){
        $this->view->render("Setting/Index");
    }

    public function Form(){

        $expenseName = new ExpenseName();
        if(isset($_GET["ID"]) && $_GET["ID"]>0){
            $data = $this->expenseNameRepository->GetById($_GET["ID"]);
            $expenseName->MapParameters($data[0]);
        }
        $param["expenseName"] = $expenseName;
        $this->view->render("Setting/Form",$param);
    }

    public function SaveUpdate(){

        $expenseName = new ExpenseName();
        $expenseName->MapParameters($_POST);
        if(isset($_POST) && $_POST["ID"]>0){
            $this->expenseNameRepository->Update($expenseName);
        }
        else{
            $this->expenseNameRepository->Save($expenseName);
        }
        $this->Redirect("Setting");

    }


    public function Delete(){
       $status = $this->expenseNameRepository->Delete($_POST["ID"]);
        $this->Redirect("Setting");
    }

    public function FindAll(){

        $ajaxGrid = new AjaxModel();
        $ajaxGrid->MapParameters($_GET);
        echo json_encode($this->expenseNameRepository->FindAll($ajaxGrid));

    }

}