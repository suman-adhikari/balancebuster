<?php

namespace Repository;
use Model\Expenses;
use Shared\AjaxGrid\AjaxGridResult;
use Shared\AjaxGrid\AjaxModel;
use System\MVC\Repo;

class ExpensesRepository extends Repo {

    public function __constructor(){
        parent::__construct();
    }

    public function Save(Expenses $expenses){

        $sth = $this->dbc->con();
        $qry = $sth->prepare("Insert into EXPENSES (name,price,expensetype,date,description) values(:name,:price,:expensetype,:date,:description)");
        $status =$qry->execute(array(':name'=>$expenses->Name, ':price'=>$expenses->Price, ':expensetype'=>$expenses->ExpenseType, ':date'=>$expenses->Date,':description'=>$expenses->Description));
        return $status;
    }

    public function Update(Expenses $expenses){
        //dd($expenses->Date);
        $qry = $this->dbc->con()->prepare("Update Expenses set `name`=?, price=?, expenseType=?, date=?, description=? where ID=? ");
        //dd($qry);
        $status = $qry->execute(array($expenses->Name,$expenses->Price,$expenses->ExpenseType,$expenses->Date,$expenses->Description,$expenses->Id));
        return $status;
    }

    public function FindAll(AjaxModel $ajaxGrid){

        $sth = $this->dbc->con();
        $sql = "select ID, Name,Price,Description,Date,
                 (select name from expensename where id = Expenses.expenseType) as ExpenseType
                   from Expenses order by ";
        $sql .= "$ajaxGrid->sortExpression $ajaxGrid->sortOrder";
        $sql .= " LIMIT $ajaxGrid->rowNumber offset $ajaxGrid->offset";

        $qry = $sth->prepare($sql);
        $qry->execute();
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC); // this will fetch result as Associative array, with key as database column name.

        $rowQuery = $this->dbc->con()->prepare("select count(*) from Expenses");
        $rowQuery->execute();
        $row = $rowQuery->fetchColumn();

        $list["PageNumber"] = $ajaxGrid->pageNumber;
        $list["Data"]= $data;
        $list["RowCount"] = $row;
        return $list;
    }

    public function AllData(){
        $sth=$this->dbc->con();
        $sql= "select ID, Name,Price,Description,Date,
                 (select name from expensename where id = Expenses.expenseType) as ExpenseType
                   from Expenses order by Date desc";
        $qry = $sth->prepare($sql);
        $qry->execute();
        $data= $qry->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function GetById($id=0){
        $conn = $this->dbc->con();
        $qry = $conn->prepare("Select * from Expenses where ID=?");
        $status = $qry->execute(array($id));
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function DeleteById($id=0){
        $qry = $this->dbc->con()->prepare("Delete from Expenses where ID=?");
        $status = $qry->execute(array($id));
        return $status;
    }

}