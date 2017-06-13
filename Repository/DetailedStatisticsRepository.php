<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 24/01/2017
 * Time: 21:49
 */

namespace Repository;


use System\MVC\Repo;

class DetailedStatisticsRepository extends Repo {

    function __construct()
    {
        parent::__construct();
    }

    public function GetExpenseType(){
        $sql="SELECT ID,NAME FROM expensename";
        $con = $this->dbc->con();
        $qry =$con->prepare($sql);
        $qry->execute();
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function GetAll($interval,$expenseType,$dateFrom,$dateTo){
        if($interval=="Daily"){
            $sql="SELECT * FROM(
                    SELECT
                      IFNULL(Price,0) AS Price,
                      date(c.date) AS DATE
                    FROM
                      (SELECT
                        SUM(Price) AS Price,
                        DATE(DATE) AS DATE
                      FROM
                        Expenses e where e.ExpenseType = $expenseType
                      GROUP BY date(DATE))t
                      RIGHT JOIN
                      calender c ON
                      t.DATE = c.date
                      WHERE c.date BETWEEN '$dateFrom' AND '$dateTo'
                      ORDER BY DATE DESC
                      )temp
                      ORDER BY DATE ASC";

        }
        else if($interval=="Weekly"){
            $sql="SELECT SUM(Price) AS Price, CONCAT('week:',WEEK(DATE)) AS DATE  FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY CONCAT('week:',WEEK(DATE))";
        }
        else if($interval=="Monthly"){
            $sql="SELECT SUM(Price)AS Price, MONTHNAME(DATE) AS DATE FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY MONTHNAME(DATE)";
        }
        else if($interval=="Yearly"){
            $sql="SELECT SUM(Price)AS Price, YEAR(DATE) AS DATE FROM Expenses GROUP BY YEAR(DATE)";
        }
        else
        {
            $sql="SELECT SUM(Price)AS Price, DATE(DATE) as DATE,
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