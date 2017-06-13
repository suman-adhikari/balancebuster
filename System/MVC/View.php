<?php
/**
 * Created by PhpStorm.
 * User: aoe
 * Date: 09/01/2016
 * Time: 22:45
 */

namespace System\MVC;

class View {

    public $data;

    public function render($file,$data=array()){

        if (!empty($data)) extract($data); //EXPOSE MODEL FOR USE IN FORM,This function uses array keys as variable names and values as variable values. For each element it will create a variable in the current symbol table.
        $this->data = $data;
        include "View/$file.php";

    }


}