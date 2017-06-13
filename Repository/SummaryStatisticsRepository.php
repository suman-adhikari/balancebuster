<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 21/02/2016
 * Time: 08:01
 */

namespace Repository;


use System\MVC\Repo;

class SummaryStatisticsRepository extends Repo {

    function __construct(){
        parent::__construct();
    }

    public function AllData($date){

        if($date=="Daily"){
            $sql="SELECT * FROM(
                    SELECT
                      IFNULL(Price,0) AS Price,
                      date(c.date) AS DATE
                    FROM
                      (SELECT
                        SUM(Price) AS Price,
                        DATE(DATE) AS DATE
                      FROM
                        Expenses
                      GROUP BY date(DATE))t
                      RIGHT JOIN
                      calender c ON
                      t.DATE = c.date
                      WHERE c.date < ADDDATE(CURRENT_DATE,1)
                      ORDER BY DATE DESC
                      LIMIT 0,30)temp
                      ORDER BY DATE ASC";

        }
        else if($date=="Weekly"){
            $sql="SELECT SUM(Price) AS Price, CONCAT('week:',WEEK(DATE)) AS DATE  FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY CONCAT('week:',WEEK(DATE))";
        }
        else if($date=="Monthly"){
            $sql="SELECT SUM(Price)AS Price, MONTHNAME(DATE) AS DATE FROM Expenses WHERE YEAR(DATE)=YEAR(CURDATE()) GROUP BY MONTHNAME(DATE)";
        }
        else if($date=="Yearly"){
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
        //var_dump($data);exit;
        return $data;
    }

}