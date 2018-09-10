<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 13/02/2016
 * Time: 08:12
 */
?>

<style>

    .pie-legend li span{
        display: inline-block;
        width: 100%;
        height:25px;
        margin-right:0px;
        padding: 3px;
        margin-top: 7px;
        color:#ffffff;
    }
    ul{ list-style-type: none;}

    .line-legend li span{
        display: inline-block;
        width: 100%;
        height:25px;
        margin-right:0px;
        padding: 3px;
        margin-top: 7px;
        color:#ffffff;
    }
    ul{ list-style-type: none;}

    .bar-legend{

    }

</style>

<?php
//$PageTitle = "Home";
$Breadcrumb = "<li><a href=''>GeneralStatistics</a></li>
<li class='active'>GeneralStatistics</li>";
$PageLeftHeader = "";
include_once 'C:/wamp64/www/BalanceBuster/Shared/Views/base.php';

?>

<div class="col-lg-12">

    <div class="col-lg-12">
      <form action="" method="post" id="dateOpt">
       <input type="button" id="chartToday" class="btn btn-primary btn-md active dateOpt" value="Daily"/>
       <input type="button" id="chartWeek" class="btn btn-primary dateOpt" value="Weekly"/>
       <input type="button" id="chartMonth" class="btn btn-primary dateOpt" value="Monthly"/>
       <input  type="button" class="btn btn-primary dateOpt" value="Yearly"/>

    </div>


    <div class="col-lg-12">

        <div class="col-lg-10" >
            <canvas id="canvas" width="750" height="500" ></canvas>
        </div>

        <div class="col-lg-2">
            <span style=" margin: 20%; font-size:18px; font-family: RobotoRegular;"> Index </span>
            <div class="pie-legend" id="pie-legend" style="width: 100%" >
        </div>
    </div>


    <div class="col-lg-12">

        <div class="col-lg-10" >
            <canvas id="canvasLine" width="780" height="500" ></canvas>
        </div>

        <div class="col-lg-2">
            <span style=" margin: 20%; font-size:18px; font-family: RobotoRegular;"> Index </span>
            <div class="pie-legend" id="pie-legend1" style="width: 100%" >
            </div>

    </div>


</div>

<script type="text/javascript">

    $(".dateOpt").click(function(){
        $.ajax({
            url:'<?php echo BASE_URL ?>GeneralStatistics/GetAll?opt='+$(this).val(),
            //url:'<?php echo BASE_URL ?>GeneralStatistics/GetAll',
            method:"GET",
            Data:"Today",
            success:function($result){
               createChart($result);
            }
        });
    });

    function createChart($response) {

        var $data = JSON.parse($response);

       /* $data = [
            {"Price": "150", "DATE": "January", "ExpenseType": "Food"},
            {"Price": "3000", "DATE": "January", "ExpenseType": "House Rent"},
            {"Price": "130", "DATE": "February", "ExpenseType": "Beverage"},
            {"Price": "90", "DATE": "February", "ExpenseType": "Food"},
            {"Price": "1200", "DATE": "February", "ExpenseType": "House Rent"},
            {"Price": "200", "DATE": "March", "ExpenseType": "Cloth"}
        ]*/


        function ChartLabelLegend() {
            var $label = [];
            var $month = [];
            $.each($data, function (k, v) {
                if ($.inArray(v.DATE, $month) == -1) {
                    $month.push(v.DATE);
                }
                if ($.inArray(v.ExpenseType, $label) == -1) {
                    $label.push(v.ExpenseType);
                }
            });

            return [$label, $month];
        }

        function DataSeries() {
            $temp="";
            $count=0;
            var $dataSeries = [];
            var $i = -1;
            var $j=0;
            var $month = ChartLabelLegend()[1];
            var $label = ChartLabelLegend()[0];
            $.each($label, function (key, value) {
                $i++;
                $dataSeries.push([]);

                    $.each($data, function (k, v) {

                            if (value == v.ExpenseType && $month[$j] == v.DATE) {
                                $dataSeries[$i].push(v.Price);
                                $temp=$month[$j];
                                $j++;

                            }
                            else {

                                if($month[$j] != v.DATE && $temp!=v.DATE ){
                                    $dataSeries[$i].push(0);
                                    $j++;
                                    if($month[$j]== v.DATE && value== v.ExpenseType){
                                        $dataSeries[$i].push(v.Price);
                                        $j++;
                                    }
                                }

                                if(k==$data.length-1){
                                    $dataSeries[$i].push(0);
                                    $j++;
                                }

                            }

                    });

                $j=0;
                $temp="";
            });
            return $dataSeries;
        }

        var $color = ["royalblue", "#CC99CC", "#90848e", "orange", "pink", "maroon", "orange", "#CC99CC"];
        //$color=["rgba(151,187,205,0.2)","rgba(220,220,220,0.2)","#C0C0C0","#E0400A","#FCB441","#056492","purple","royalblue","maroon","pink"];
        var $fillColor = ["rgba(0, 0, 131, 0.1)", "rgba(255,69,0,0.1)", "rgba(61, 138, 131, 0.1)", "rgba(255,255,0,0.1)", "rgba(29, 180, 18,0.1)", "rgba(180, 18, 37,0.1)", "rgba(6, 238, 176,0.1)"];   //	255,215,0
        var $strokeColor = ["rgba(0, 0, 131, 0.8)", "rgba(255,69,0,0.8)", "rgba(61, 138, 131, 0.8)", "rgba(255,255,0,0.8)", "rgba(29, 180, 18,0.8)", "rgba(180, 18, 37,0.8)", "rgba(6, 238, 176,0.8)"];
        var $pointStrokeColor = ["rgba(0, 0, 131, 1)", "rgba(255,69,0,1)", "rgba(61, 138, 131, 1)", "rgba(255,255,0,1)", "rgba(29, 180, 18,1)", "rgba(180, 18, 37,1)", "rgba(6, 238, 176,1)"];

        function DataSet_bar(){
            var $dataSet = [];
            var $dataSeries = DataSeries();
            var $label = ChartLabelLegend()[0];

            $.each($dataSeries,function(k,v){
                  var obj = {
                      label:$label[k],
                      fillColor:$color[k],
                      strokeColor:$color[k],
                      pointStrokeColor:$color[k],
                      highlightFill:$color[k],
                      highlightStroke:$color[k],
                      data:v
                  };
                $dataSet.push(obj);

            });
            return $dataSet;
        }

        function DataSet_line(){
            var $dataSet = [];
            var $dataSeries = DataSeries();
            var $label = ChartLabelLegend()[0];

            $.each($dataSeries,function(k,v){
                var obj = {
                    label:$label[k],
                    fillColor:$fillColor[k],
                    strokeColor:$pointStrokeColor[k],
                    pointColor:$strokeColor[k],
                    pointStrokeColor:$pointStrokeColor[k],
                    highlightFill:$color[k],
                    highlightStroke:$color[k],
                    data:v
                };
                $dataSet.push(obj);

            });
            return $dataSet;
        }


        var barChartData = {

            labels:ChartLabelLegend()[1],
            datasets:DataSet_bar()

        }

        var LineChartData = {

            labels:ChartLabelLegend()[1],
            datasets:DataSet_line()

        }
		
		var Options = {
			showAllTooltips: true
			
		};


        var ctx = $("#canvas").get(0).getContext("2d");
        var BarChart = new Chart(ctx).Bar(barChartData,Options);
        document.getElementById('pie-legend').innerHTML = BarChart.generateLegend()
        BarChart.destroy();

        var ctx = $("#canvasLine").get(0).getContext("2d");
        var LineChart = new Chart(ctx).Line(LineChartData,{});
        document.getElementById('pie-legend1').innerHTML = LineChart.generateLegend();
        LineChart.destroy();

       // canvasLine


    }



</script>