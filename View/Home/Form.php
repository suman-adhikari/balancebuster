
<form action="<?php BASE_URL ?>Home/SaveUpdate" method="post" id="addExpense">

<div id="mainModal">

    <input type="hidden" id="Id" name="Id" value="<?= $expense->Id ?>" >

    <div class="form-group">
        <div class="col-xs-5">
            <label class="control-label" for="name" >Name</label>
        </div>
        <div class="col-xs-7">
           <input class="form-control" type="text" placeholder="Footsal" id="Name" name="Name" value="<?= $expense->Name ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5">
            <label class="control-label" for="name" >Price</label>
        </div>
        <div class="col-xs-7">
            <input class="form-control" type="text" placeholder="500" id="Price" name="Price" value="<?= $expense->Price ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5">
            <label class="control-label" for="name" >DateTime</label>
        </div>
        <div class="col-xs-7">
            <input class="form-control" type="text" placeholder="name here" id="Date" name="Date" value="<?= $expense->Date ?>"/>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5">
            <label class="control-label" for="name" >Expense Type</label>
        </div>
        <div class="col-xs-7">
            <select class="form-control" type="text" placeholder="name here" id="ExpenseType" name="ExpenseType">
                <?php
                   foreach($expenseName as $row){
                       if($row["ID"]==$expense->ExpenseType) {
                           echo '<option selected value=' . $row["ID"] . '>' . $row["Name"] . '</option>';
                       }else {
                           echo '<option value=' . $row["ID"] . '>' . $row["Name"] . '</option>';
                       }
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5">
            <label class="control-label" for="name" >Description</label>
        </div>
        <div class="col-xs-7">
            <input class="form-control" type="text" placeholder="name here" id="Description" name="Description" value="<?= $expense->Description ?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12">
            <input type="submit" id="btn_save" value="Save" class="btn btn-primary" />
            <input type="button" id="btn_cancel" value="Cancel" class="btn btn-primary" onclick=" closeDialog(this) " />
        </div>
    </div>

</div>

</form>

<script>

    $(function(){
        $("#Date").datepicker({dateFormat: 'yy-mm-dd'});
    });

</script>

