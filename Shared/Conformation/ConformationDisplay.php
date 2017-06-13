<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 15/01/2016
 * Time: 23:22
 */

namespace Shared\Conformation;
use Shared\Session\SessionModel;

class ConformationDisplay {

    public static function SetConfirmation(ConformationModel $conformation)
    {

        if (is_array($conformation->Message))
            $_SESSION[SessionModel::$ConfirmationMessage] = implode("<br />", $conformation->Message);
        else
            $_SESSION[SessionModel::$ConfirmationMessage] = $conformation->Message;

        $_SESSION[SessionModel::$ConfirmationMessageType] = $conformation->MessageType;

    }

}