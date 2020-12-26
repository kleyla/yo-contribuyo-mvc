<?php
$controller = ucwords($controller);
$controllerFile = "Controllers/".$controller.".php";
// echo $controller;
if(file_exists($controllerFile)){
    require_once($controllerFile);
    $controller = new $controller();
    if(method_exists($controller, $method)){
        $controller->{$method}($params);
    } else{
        // echo "No existe el metodo";
        require_once("Controllers/Error.php");
    }
}else{
    // echo "No existe controllador";
    require_once("Controllers/Error.php");
}
