#!/usr/bin/python
# -*- coding: utf-8 -*-
import pymssql
import pymysql
import sys


class ExportRepo:

    db = ""
    cursor = ""

    def __init__(self, hostName, userName, password, database, encoding):
        db = pymysql.connect(host=hostName, user=userName, passwd=password, db=database, charset=encoding, )
        ExportRepo.cursor = db.cursor(pymysql.cursors.DictCursor)

    def closeConnection(self):
        ExportRepo.db.close()
        ExportRepo.cursor.close()


    def GetData(self,interval,dateFrom,dateTo):

        if (dateFrom != "false" and dateTo != "false"):
            sql_condition = " AND DATE(c.`Date`) BETWEEN '"+ dateFrom + "' AND '" + dateTo + "'"


        if(interval != " "):
            if(interval=="Monthly"):
                sql="""SELECT c.`Date` AS `Date`,IFNULL(SUM(Price),0) AS Price FROM expenses e
                       RIGHT OUTER JOIN `calender` c
                       ON DATE(e.`Date`) = c.`Date`
                       WHERE YEAR(c.`Date`)= YEAR(CURRENT_DATE)
                       GROUP BY MONTH(c.Date)"""
                
            elif(interval=="Yearly"):
                sql = """SELECT YEAR(c.`Date`) AS `Date`,IFNULL(SUM(Price),0) AS Price FROM expenses e
                           RIGHT OUTER JOIN `calender` c
                           ON DATE(e.`Date`) = c.`Date`
                           GROUP BY YEAR(c.Date)
                           HAVING SUM(Price) <> '0'"""

            else:
                sql = """SELECT c.`Date` AS `Date`,IFNULL(SUM(Price),0) AS Price FROM expenses e
                                                 RIGHT OUTER JOIN `calender` c
                                                 ON DATE(e.`Date`) = c.`Date`
                                                 Where 1=1""" + sql_condition + """ GROUP BY c.Date"""


        else:
            if (dateFrom != "false" and dateTo != "false"):
                sql_condition = " AND DATE(c.`Date`) BETWEEN '"+ dateFrom + "' AND '" + dateTo + "'"

            sql = """SELECT c.`Date` as Date,IFNULL(SUM(Price),0) AS Price FROM expenses e
                     RIGHT OUTER JOIN `calender` c
                     ON DATE(e.`Date`) = c.`Date`
                     Where 1=1""" + sql_condition + """ GROUP BY c.Date"""

        #print sql;
        #sys.exit();
        ExportRepo.cursor.execute(sql)
        result = ExportRepo.cursor.fetchall()
        return result


    def GetDataGeneral(self,dateFrom,dateTo,expName,interval):


            if(interval):
                if(interval=="Monthly"):
                    sql="""SELECT DATE_FORMAT(c.date,'%Y-%m') AS `Date`, IFNULL(temp.price,0) AS Price FROM(
                           SELECT `Name`,SUM(Price) AS price,DATE(`DateTime`) AS `Date` FROM exps
                           WHERE `Name`='""" + expName + """' AND YEAR(`DateTime`)=YEAR(CURRENT_DATE) GROUP BY MONTH(`DateTime`))temp
                           RIGHT OUTER JOIN
                           (SELECT DATE(`date`) AS `Date` FROM calendar WHERE YEAR(`date`)=YEAR(CURRENT_DATE) GROUP BY MONTH(`date`))c
                           ON
                           DATE_FORMAT(DATE(temp.`Date`),'%Y-%m') = DATE_FORMAT(DATE(c.`Date`),'%Y-%m')
                           ORDER BY c.`date` ASC"""

                else:
                    sql = """SELECT SUM(Price) AS Price, DATE_FORMAT((`DateTime`),'%Y') AS `Date` FROM exps WHERE `name`='""" + expName + """' GROUP BY YEAR(`DateTime`)"""


            else:
                if (dateFrom != "false" and dateTo != "false"):
                    sql_condition = " AND DATE(c.`Date`) BETWEEN '"+ dateFrom + "' AND '" + dateTo + "'"


                sql = """SELECT c.date AS `Date`,IFNULL(temp.price,0) AS Price FROM(
                         SELECT DATE(`DateTime`) AS `Date`,SUM(price) AS price FROM exps WHERE `name`='""" + expName + """' GROUP BY DATE(`datetime`))temp
                         RIGHT OUTER JOIN  calendar c
                         ON DATE(temp.`Date`) = c.date
                         Where 1=1""" + sql_condition + "order by date asc"

            #print sql;
            #sys.exit();
            ExportRepo.cursor.execute(sql)
            result = ExportRepo.cursor.fetchall()
            return result



