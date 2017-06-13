<?php
//$PageTitle = "Home";
$Breadcrumb = "<li><a href=''>BalanceBuster</a></li>
<li class='active'>DashBoard</li>";
$PageLeftHeader = "";
include_once 'C:/wamp64/www/BalanceBuster/Shared/Views/base.php';

?>

<style>



</style>

<div class="col-lg-12" style="display: inline-block;">

    <div class="firstrow" style=" " >

        <span class="firstrowText" style="">TODAY EXPENSE</span>
        <span class="firstrowValue" id="fr1" style=""></span>
        <hr>
        <span class="firstrowSubtext" id="fr1comment"></span>

    </div>

    <div class="firstrow" style=" " >

        <span class="firstrowText" style="">WEEK EXPENSE</span>
        <span class="firstrowValue" id="fr2" style="">5689</span>
        <hr>
        <span class="firstrowSubtext" id="fr2comment"></span>

    </div>

    <div class="firstrow" style="">

        <span class="firstrowText" style="">MONTH EXPENSE</span>
        <span class="firstrowValue" id="fr3" style="">568</span>
        <hr>
        <span class="firstrowSubtext" id="fr3comment"></span>


    </div>

    <div class="firstrow" style="">

        <span class="firstrowText" style="">YEAR EXPENSE</span>
        <span class="firstrowValue" id="fr4" style="">56</span>
        <hr>
        <span class="firstrowSubtext" id="fr4comment"></span>

    </div>

    <div class="firstrow" style="">
        <span class="firstrowText" style="">HIGHEST EXPENSE</span>
        <span class="firstrowValue" id="fr5" style="">56</span>
        <hr>
        <span class="firstrowSubtext" id="fr5comment"></span>
    </div>


</div>


<div class="col-lg-12" style="display: inline-block;">

    <div class="secondrow sr_one" style=" padding: 10px; " >

            <canvas id="canvasLine" width="750" height="400" ></canvas>


    </div>

    <div class="secondrow sr_two" style="padding:10px" >


        <canvas id="canvasPie" width="150" height="190" ></canvas>
        <div id="js-legend" class="chart-legend"></div>

    </div>

</div>

<div class="clearfix"></div>


<script type="text/javascript">

    $(function(){
        $.ajax({
            url:'<?php echo BASE_URL ?>SummaryStatistics/GetAll?opt=Daily',
            //url:'<?php echo BASE_URL ?>GeneralStatistics/GetAll',
            method:"GET",
            Data:"Today",
            success:function($result){
                createChart($result);
            }
        });
    });

    debugger;
    $(function(){
        $.ajax({
           url:'<?php echo BASE_URL ?>Dashboard/DashboardData',
           method:"GET",
           success:function($result){
               $data = JSON.parse($result);
               $('#fr1').html($data[0]["_day"]);
               $('#fr2').html($data[0]["_week"]);
               $('#fr3').html($data[0]["_month"]);
               $('#fr4').html($data[0]["_year"]);
               $('#fr5').html($data[0]["HighestExp"]);

               $dayPercent = $data[0]["_dayDiff"];
               $weekPercent = $data[0]["_weekDiff"];
               $monthPercent =$data[0]["_monthDiff"];
               $yearPercent  = $data[0]["_yearDiff"];



               $('#fr1comment').html(($dayPercent>0? "Increased by ":"Decrease by ").concat(Math.abs($dayPercent)+" %"));
               $('#fr2comment').html(($weekPercent>0? "Increased by ":"Decrease by ").concat(Math.abs($weekPercent)+" %"));
               $('#fr3comment').html(($monthPercent>0? "Increased by ":"Decrease by ").concat(Math.abs($monthPercent)+" %"));
               $('#fr4comment').html(($yearPercent>0? "Increased by ":"Decrease by ").concat(Math.abs($yearPercent)+" %"));
               $('#fr5comment').html($data[0]["HighestExp"]);


           }
        });
    });


    function createChart($response) {

        var $data = JSON.parse($response);

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

        var LineChartData = {

            labels:ChartLabelLegend()[1],
            datasets:DataSet_line()

        }

        var PieData = [
            {
                value: 300,
                color:"#3f51b5",
                highlight: "#3f51b5",
                label: "Spent"
            },
            {
                value: 50,
                color: "ROYALBLUE",
                highlight: "#5AD3D1",
                label: "Remaining"
            }
        ]

        var options =
        {
            scaleShowGridLines : false,
            scaleGridLineColor : "white",
            bezierCurve : false,
            pointDot : false,
            pointDotRadius : 4,
            scaleFontColor: "#e8bef4",
            percentageInnerCutout: 80
        };


        var ctx = $("#canvasLine").get(0).getContext("2d");
        var LineChart = new Chart(ctx).Line(LineChartData,options);

        var ctx = $("#canvasPie").get(0).getContext("2d");
        var PieChart = new Chart(ctx).Pie(PieData,options);
        document.getElementById('js-legend').innerHTML = PieChart.generateLegend();


    }




</script>