<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 17/01/2016
 * Time: 18:02
 */

namespace Repository;


use Model\ExpenseName;
use Shared\AjaxGrid\AjaxModel;
use System\MVC\Repo;

class ExpenseNameRepository extends  Repo{

    public function __construct(){
        parent::__construct();
    }

    public function FindAll(AjaxModel $ajaxGrid){

        $sth = $this->dbc->con();
        $sql = "Select * from ExpenseName order by ";
        $sql.= "$ajaxGrid->sortExpression $ajaxGrid->sortOrder";
        $sql.= " LIMIT $ajaxGrid->rowNumber offset $ajaxGrid->offset";
        $qry = $sth->prepare($sql);
        $qry->execute();
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC);

        $list["Data"] = $data;
        $list["PageNumber"] = 1;
        $list["RowCount"]=10;

        return $list;
    }

    public function FindAllName(){

        $sth = $this->dbc->con();
        $qry = $sth->prepare("Select Name,ID from ExpenseName");
        $qry->execute();
        $result = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

    public function Delete($id=0){

        $qry = $this->dbc->con()->prepare("Delete from ExpenseName where ID=?");
        $status = $qry->execute(array($id));
        return $status;

    }

    public function GetById($id=0){
        $conn = $this->dbc->con();
        $qry = $conn->prepare("Select * from ExpenseName where ID=?");
        $status = $qry->execute(array($id));
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function Save(ExpenseName $expenseName){

        $sth = $this->dbc->con();
        $qry = $sth->prepare("Insert into ExpenseName (name) values(:name)");
        $status = $qry->execute(array(':name'=>$expenseName->Name));
        return $status;
    }

    public function Update(ExpenseName $expenseName){

        $sth = $this->dbc->con();
        $qry = $sth->prepare("Update ExpenseName set name=? where ID=?");
        $status = $qry->execute(array($expenseName->Name, $expenseName->ID));
        return $status;
    }


}