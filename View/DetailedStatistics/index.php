<?php
/**
 * Created by PhpStorm.
 * User: suman
 * Date: 24/01/2017
 * Time: 21:50
 */

$Breadcrumb = "<li><a href=''>DetailedStatistics</a></li>
<li class='active'>DetailedStatistics</li>";
$PageLeftHeader = "";
include_once 'C:/wamp64/www/BalanceBuster/Shared/Views/base.php';

?>



<div class="col-md-12">

    <div class="col-lg-12">

       <select name="ExpenseType" id="ExpenseType">
           <?php
            foreach($expenseType as $item)
              echo "<option value=".$item["ID"].">".$item["NAME"]."</option>"
           ?>
       </select>

        <input type="text" name="dateFrom" id="dateFrom" class="from-inline" value=""/>
        <input type="text" name="dateTo" id="dateTo" class="form-inline" value=""/>
        <button class="btn" style="vertical-align: top" id="GetData">Get Data</button>

        <input type="button" id="chartToday" class="btn btn-primary btn-md active dateOpt" value="Daily"/>
        <input type="button" id="chartWeek" class="btn btn-primary dateOpt" value="Weekly"/>
        <input type="button" id="chartMonth" class="btn btn-primary dateOpt" value="Monthly"/>
        <input  type="button" id="chartYearly"  class="btn btn-primary dateOpt" value="Yearly"/>


        <form action="SummaryStatistics/Export" method="post" class="pull-right" style="margin-left: 10px" id="ExportForm">
            <input type="hidden" name="TemplateExport" id="TemplateExport"/>
            <input type="hidden" name="DateFrom" id="DateFrom"/>
            <input type="hidden" name="DateTo" id="DateTo"/>
            <input type="hidden" name="interval" id="interval"/>
            <div class="form-group mr20">
                <button class="btn btn-success" style="vertical-align: top" id="export">Export</button>
            </div>
        </form>


    </div>

    <div class="clearfix"></div>

    <hr style="border-top: 1px solid #336699 !important;">

    <div class="col-lg-12">

        <div class="col-lg-12" ng-if="chartLoaded" >
            <canvas id="canvas" width="950" height="500" ></canvas>
        </div>

        <div class="clearfix"></div>

        <hr style="border-top: 1px solid lightgray !important;">

        <div class="col-lg-12">

            <div class="col-lg-12" >
                <canvas id="canvasLine" width="950" height="500" ></canvas>
            </div>

            <!-- <div class="col-lg-2">
                 <span style=" margin: 20%; font-size:18px; font-family: RobotoRegular;"> Index </span>
                 <div class="pie-legend" id="pie-legend1" style="width: 100%" >
                 </div>

             </div>-->


        </div>
    </div>


</div>

<script>

    $("#dateFrom").datepicker({dateFormat: 'yy-mm-dd'});
    $("#dateTo").datepicker({dateFormat: 'yy-mm-dd'});

    var d = new Date();
    d.getYear();
    d.getMonth();
    d.getDate();

    var date_to = d.getFullYear()+"-"+ (d.getMonth()+1)+"-"+d.getDate();

    var date_from = d.setMonth(d.getMonth()-1);
    date_from = new Date(date_from);
    date_from.getYear();
    date_from.getMonth();
    date_from.getDate();
    date_from = date_from.getFullYear()+"-"+ (date_from.getMonth()+1)+"-"+date_from.getDate();


    $("#interval").val("Daily");
    $("#dateFrom").val(date_from);
    $("#dateTo").val(date_to);

    $("#ExpenseType").on("change",function(){
        LoadStats();
    });


    $("#GetData").click(function(){
        LoadStats();
    })

    $(document).ready(function(){
        $("#ExpenseType").val(13);
        $("#chartToday").val("Daily");
        LoadStats();

    });

    function LoadStats($expenseId){
        var expenseId = $("#ExpenseType").val();
        var interval = $(".dateOpt").val();
        var dateFrom = $("#dateFrom").val();
        var dateTo = $("#dateTo").val();

        $.ajax({
            url:'<?php echo BASE_URL ?>DetailedStatistics/GetAll',
            method:"GET",
            data:{Interval:interval,ExpenseId:expenseId,DateFrom:dateFrom,DateTo:dateTo},
            success:function($result){
                createChart($result);
            }
        });
    }

   /* $(".dateOpt").click(function(){
        $.ajax({
            url:'<?php echo BASE_URL ?>DetailedStatistics/GetAll?opt='+$(this).val()+'&expenseType='+$("#ExpenseType").val(),
            method:"GET",
            Data:"Today",
            success:function($result){
                debugger;
                createChart($result);
            }
        });
    });*/


    function createChart($response) {

        var $data = JSON.parse($response);
        var $color = ["royalblue", "#CC99CC", "#90848e", "orange", "pink", "maroon", "orange", "#CC99CC"];
        //$color=["rgba(151,187,205,0.2)","rgba(220,220,220,0.2)","#C0C0C0","#E0400A","#FCB441","#056492","purple","royalblue","maroon","pink"];
        var $fillColor = ["rgba(0, 0, 131, 0.1)", "rgba(255,69,0,0.1)", "rgba(61, 138, 131, 0.1)", "rgba(255,255,0,0.1)", "rgba(29, 180, 18,0.1)", "rgba(180, 18, 37,0.1)", "rgba(6, 238, 176,0.1)"];   //	255,215,0
        var $strokeColor = ["rgba(0, 0, 131, 0.8)", "rgba(255,69,0,0.8)", "rgba(61, 138, 131, 0.8)", "rgba(255,255,0,0.8)", "rgba(29, 180, 18,0.8)", "rgba(180, 18, 37,0.8)", "rgba(6, 238, 176,0.8)"];
        var $pointStrokeColor = ["rgba(0, 0, 131, 1)", "rgba(255,69,0,1)", "rgba(61, 138, 131, 1)", "rgba(255,255,0,1)", "rgba(29, 180, 18,1)", "rgba(180, 18, 37,1)", "rgba(6, 238, 176,1)"];

        var $_date=[];
        var $_value=[];
        $.each($data,function(k,v){
            $_date.push(v["DATE"]);
            $_value.push(v["Price"]);
        })

        var barChartData = {
            labels:$_date ,
            datasets: [
                {
                    label: 'ABC',
                    fillColor: $pointStrokeColor[2],
                    data:$_value
                }
            ]
        };

        var num=2;
        var lineChartDate={
            labels:$_date ,
            hover: {
                // Overrides the global setting
                mode: 'index'
            },
            datasets: [
                {
                    label: 'ABC',
                    color: $color[num],
                    fillColor: $fillColor[num],
                    strokeColor: $strokeColor[num],
                    pointColor: $pointStrokeColor[num],
                    data:$_value
                }
            ]
        }

        var ctx = $("#canvas").get(0).getContext("2d");
        var BarChart = new Chart(ctx).Bar(barChartData,{options});
        //document.getElementById('pie-legend').innerHTML = BarChart.generateLegend()
        BarChart.destroy();

        var ctx1 = $("#canvasLine").get(0).getContext("2d");
        var LineChart = new Chart(ctx1).Line(lineChartDate,{options1});
        //document.getElementById('pie-legend1').innerHTML = LineChart.generateLegend();
        LineChart.destroy();

        // canvasLine

    }


    var options =
    {
        tooltipTemplate: "<"+ "%= value %" + ">",
        onAnimationComplete: function()
        {
            this.showTooltip(this.segments, true);
        },
        showTooltips: true,
        percentageInnerCutout: 10,
        responsive: true,
        title:{
            display:true,
            text:"Chart.js Bar Chart - Stacked"
        },
        tooltips: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'probability'
                }
            }],
            yAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'probability'
                }
            }]
        }
    };

    var options1 = {
        segmentShowStroke: false,
        animateRotate: true,
        animateScale: false,
        percentageInnerCutout: 50,
        tooltipTemplate: "<%= value %>",
        responsive: true
    };

</script>