<?php
/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 5/29/2017
 * Time: 8:41 AM
 */

namespace Repository;


use Shared\AjaxGrid\AjaxModel;
use System\MVC\Repo;

class BalanceRepository extends Repo {

    public function __construct(){
       parent::__construct();
   }

    public function FindAll(AjaxModel $ajaxGrid){
        $sth = $this->dbc->con();
        $sql = "Select * from Balance order by ";
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

}