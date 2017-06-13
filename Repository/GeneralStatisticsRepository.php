<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 13/02/2016
 * Time: 08:55
 */

namespace Repository;


use System\MVC\Repo;

class GeneralStatisticsRepository extends repo {

    public function AllData($date){

        if($date=="Daily"){
            $sql="SELECT * FROM(
                  SELECT Price, DATE(DATE) as DATE,
                  (SELECT NAME FROM expensename WHERE id = Expenses.expenseType) AS ExpenseType
                  FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY DATE,ExpenseType,Price
                )tbl ORDER BY DATE DESC LIMIT 0,7;
                   ";
        }
        else if($date=="Weekly"){
            $sql="SELECT SUM(Price)AS Price, CONCAT('week:',WEEK(DATE)) AS DATE,
                 (SELECT NAME FROM expensename WHERE id = Expenses.expenseType) AS ExpenseType
                   FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY CONCAT('week:',WEEK(DATE)),ExpenseType";
        }
        else if($date=="Monthly"){
            $sql="SELECT SUM(Price)AS Price, MONTHNAME(DATE) AS DATE,
                 (SELECT NAME FROM expensename WHERE id = Expenses.expenseType) AS ExpenseType
                   FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY MONTHNAME(DATE),ExpenseType ";
        }
        else if($date=="Yearly"){
            $sql="SELECT SUM(Price)AS Price, YEAR(DATE) AS DATE,
                 (SELECT NAME FROM expensename WHERE id = Expenses.expenseType) AS ExpenseType
                   FROM Expenses GROUP BY YEAR(DATE),ExpenseType";
        }
        else
        {
            $sql="SELECT SUM(Price)AS Price, DATE,
                 (SELECT NAME FROM expensename WHERE id = Expenses.expenseType) AS ExpenseType
                   FROM Expenses WHERE DATE=CURDATE()  GROUP BY ExpenseType ORDER BY DATE DESC";
        }

        $sth=$this->dbc->con();
        $qry = $sth->prepare($sql);
        $qry->execute();
        $data= $qry->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }



}