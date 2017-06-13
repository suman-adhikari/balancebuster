
<form action="<?php BASE_URL ?>Setting/SaveUpdate" method="post" id="addExpense">

    <div id="mainModal">

        <input type="hidden" id="ID" name="ID" value="<?= $expenseName->ID ?>" >

        <div class="form-group">
            <div class="col-xs-5">
                <label class="control-label" for="name" >Name</label>
            </div>
            <div class="col-xs-7">
                <input class="form-control" type="text" placeholder="Footsal" id="Name" name="Name" value="<?= $expenseName->Name ?>" />
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

