<?php

//$PageTitle = "Home";
$Breadcrumb = "<li><a href=''>BalanceBuster</a></li>
<li class='active'>Home</li>";
$PageLeftHeader = "";
include_once 'C:/wamp64/www/BalanceBuster/Shared/Views/base.php';

?>


<div class="page-header">

    <div class="pull-left">
        <div id="currentAmount" style="font-size: 18px; color: #660066"></div>
    </div>

    <div class="pull-right">
        <button type="button" class="btn btn-success addbtn pull-right " id="AddNew"
                onclick="showAddNewForm('Add New', '<?= BASE_URL ?>Home/Form', 400, 300);">
            <small class="glyphicon glyphicon-plus-sign"></small>
            Add New
        </button>
    </div>
    <div class="clearfix"></div>
</div>


<table class="table table-bordered table-responsive table-striped wrap-text" id="balance">
    <thead>
    <tr>
        <th><a class="table-header" field-name="Action">Action</a></th>
        <th><a class="table-header" field-name="Amount">Amount</a></th>
        <th><a class="table-header" field-name="Reason">Reason</a></th>
        <th><a class="table-header" field-name="Date">Date</a></th>
        <th><a class="table-header" field-name="CurrentAmount">CurrentAmount</a></th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
<div id="loading-msg-subscribers-management" class="loading-image">
</div>

<div class="clearfix"></div>


<script type="text/javascript">
    $(function () {
        $('#balance-menu').addClass('active');

        $('#balance').ajaxGrid({
            pageSize: 5,
            defaultSortExpression: 'ID',
            defaultSortOrder: 'DESC',
            tableHeading: '.table-header',
            url: '<?= BASE_URL ?>Balance/FindAll',
            requestType: 'get',
            loadingImage: $('#loading-msg-subscribers-management'),
            NoRecordsFound: 'No Records Found',
            postContent: [
                {
                    control: $('<button type="button" class="btn btn-primary" ' +
                    'onclick=\'showEditForm(this,"Edit","<?= BASE_URL ?>Home/Form",400,300)\'>' +
                    '<small class="glyphicon glyphicon-edit"></small></small>' +
                    '</button>')
                },
                {
                    control: $('<form action="<?= BASE_URL ?>Home/Delete" method="POST" style="display:inline-block">' +
                    '<input type="hidden" name="ID" id="ID" />'+
                    '<button type="submit" class="btn btn-danger" ' +
                    'onclick=\'return confirm("Are you sure you want to Remove this List?")\'>' +
                    '<span class="glyphicon glyphicon-remove"></span></button></form>'),
                    properties: [
                        {
                            propertyField: 'input[type=hidden]#ID',
                            property: 'value',
                            propertyValue: 'ID'
                        }
                    ]
                }
            ],
            afterAjaxCallComplete:function(data){
               var currentAmount = $($("table td")[4]).text();
               currentAmount = currentAmount.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
               $("#currentAmount").text("Current Amount: Rs."+currentAmount);
            },
            id: 'ID'
        });

    });

</script>