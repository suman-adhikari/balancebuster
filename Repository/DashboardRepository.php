<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 01/03/2016
 * Time: 21:37
 */

namespace Repository;


use System\MVC\Repo;

class DashboardRepository extends Repo {

    public function __construct(){
        parent::__construct();
    }

    public function DashboardData(){

        $sql = "SELECT
                     _day,ROUND(((_day-_pday)/_day*100),2) AS _dayDiff,
                     _week, ROUND(((_week - _pweek)/_week*100),2) AS _weekDiff,
                     _month, ROUND(((_month - _pmonth)/_month*100),2) AS _monthDiff,
                     _year, ROUND(((_year - _pyear)/_year*100),2) AS _yearDiff,
                     HighestExp
                    FROM(
                    (SELECT IFNULL(SUM(PRICE),0) AS _day FROM EXPENSES WHERE DATE(DATE)=DATE(CURDATE()))a,
                    (SELECT IFNULL(SUM(PRICE),0) AS _pday FROM EXPENSES WHERE DATE(DATE)=DATE(CURDATE() - INTERVAL 1 DAY))b,
                    (SELECT IFNULL(SUM(PRICE),0) AS _week FROM EXPENSES WHERE DATE BETWEEN DATE_SUB(DATE(CURDATE()),INTERVAL 7 DAY) AND DATE(CURDATE()))c,
                    (SELECT IFNULL(SUM(PRICE),0) AS _pweek FROM EXPENSES WHERE DATE BETWEEN DATE_SUB(DATE(CURDATE()),INTERVAL 14 DAY) AND DATE_SUB(DATE(CURDATE()),INTERVAL 7 DAY))d,
                    (SELECT IFNULL(SUM(PRICE),0) AS _month FROM EXPENSES WHERE MONTH(DATE)=MONTH(CURRENT_DATE()))e,
                    (SELECT IFNULL(SUM(PRICE),0) AS _pmonth FROM EXPENSES WHERE MONTH(DATE)=MONTH(CURRENT_DATE() - INTERVAL 1 MONTH))f,
                    (SELECT IFNULL(SUM(PRICE),0) AS _year FROM EXPENSES WHERE YEAR(DATE)=YEAR(CURRENT_DATE()))g,
                    (SELECT IFNULL(SUM(PRICE),0) AS _pyear FROM EXPENSES WHERE YEAR(DATE)=YEAR(CURRENT_DATE() - INTERVAL 1 YEAR))h,
                    (SELECT price AS HighestExp FROM expenses ORDER BY price DESC LIMIT 1)i
                    )
               ";

        $sth = $this->dbc->con();
        $qry = $sth->prepare($sql);
        $qry->execute();
        $data = $qry->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

}