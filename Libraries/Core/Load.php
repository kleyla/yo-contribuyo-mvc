<?php
$controller = ucwords($controller);
$controllerFile = "Controlador/".$controller.".php";
// echo $controller;
// echo $controllerFile;
if(file_exists($controllerFile)){
    require_once($controllerFile);
    $controller = new $controller();
    // echo $method;
    if(method_exists($controller, $method)){
        $controller->{$method}($params);
    } else{
        echo "No existe el metodo";
        require_once("Controlador/Error.php");
    }
}else{
    echo "No existe controllador";
    require_once("Controlador/Error.php");
}
