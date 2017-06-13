<?php

namespace Shared\Conformation;

class ConformationSet {

    public static function Save($status)
    {
        $conformationModel = new ConformationModel();

        $conformationModel->Message= $status ?"Successfully Saved New Expense":"Error While Saving Expense!";

        $conformationModel->MessageType = $status ? "Success" : "Failed";

        ConformationDisplay::SetConfirmation($conformationModel);
    }

    public static function Update($status)
    {
        $conformationModel = new ConformationModel();

        $conformationModel->Message= $status ?"Successfully Updated Expense Item":"Error While Updating Expense!";

        $conformationModel->MessageType = $status ? "Success" : "Failed";

        ConformationDisplay::SetConfirmation($conformationModel);
    }

    public static function Delete($status)
    {
        $conformationModel = new ConformationModel();

        $conformationModel->Message= $status ?"Successfully Deleted Expense Item":"Error While Deleting Expense!";

        $conformationModel->MessageType = $status ? "Success" : "Failed";

        ConformationDisplay::SetConfirmation($conformationModel);
    }

}