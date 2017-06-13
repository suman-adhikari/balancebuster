<?php




function dd($val="here")
{
    var_dump($val);
    exit;
}

$parts = array();
$parts = explode("/",$url);



$controller = isset($parts[0])?$parts[0]:"";
ucwords($controller);
array_shift($parts);



$action = isset($parts[0])?$parts[0]:"";
ucwords($action);
array_shift($parts);

$para = $parts;



if(empty($controller)) {
    $controller = "Login";
}

if(empty($action)){
    $action = "Index";
}

$controller = $controller.'Controller';

function __autoload($class_name){

 if(file_exists(ControllerPath.DS.$class_name.'.php')){
     include ControllerPath.DS.$class_name.'.php';
 }
else if(file_exists($class_name.'.php')){
    include $class_name.'.php';
}

}

    $controller = new $controller;
    $controller->$action($para);

