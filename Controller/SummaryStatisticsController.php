<?php
use Model\Expenses;
use Repository\SummaryStatisticsRepository;
use System\MVC\Controller;

/**
 * Created by PhpStorm.
 * User: SUMAN
 * Date: 21/02/2016
 * Time: 07:53
 */

class SummaryStatisticsController extends Controller {

    private $allExpenses;
    function __construct(){
        parent::__construct();

        $this->allExpenses= new SummaryStatisticsRepository();
    }

    public function Index(){

        $data = $this->allExpenses->AllData("Today");
        $this->view->render("SummaryStatistics/Index",$data);
    }

    public function GetAll(){

        $dateOpt = $_GET["opt"];
        echo json_encode($this->allExpenses->AllData($dateOpt));
    }

    function Export(){

        if (isset($_POST["TemplateExport"])) {

            $dateFrom = $_POST["DateFrom"];
            $dateTo = $_POST["DateTo"];
            $interval = $_POST["interval"]==""?"Daily":$_POST["interval"];

            $fileName = "exports/".date("Y_M_d_h_i_s_A")."_Template.xlsx";
            $path = "ExportTemplates.py $fileName $interval $dateFrom $dateTo ";

            //dd($path);

            $command = escapeshellcmd("C:\\Python27\\python.exe ". $path);
            $output = shell_exec($command);

            if (trim($output) == "ExportSuccess") {

                ob_start();
                header('Content-Description: File Transfer');
                header('Content-Type: application/force-download');
                header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\";");
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fileName));
                ob_clean();
                flush();
                if (readfile($fileName)) {
                    unlink($fileName);
                } //showing the path to the server where the file is to be download

            }

        }
    }

}