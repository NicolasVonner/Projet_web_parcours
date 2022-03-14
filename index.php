<?php

define("WEBROOT", str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define("ROOT", str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

//A corriger, juste pour corriger le warming
if(sizeof(explode('/',$_GET['p'])) == 1){
    $params = ["", null, null, null, null, null];
}else{
    $params = explode('/',$_GET['p']);
}

$folder= empty(!$params[0])? $params[0] : 'Index';
$controller= isset($params[1])? $params[1] : 'Index_controller';
$action = isset($params[2])? $params[2] : 'verifyConnection';
$p1 = isset($params[3])? $params[3] : null;
$p2 = isset($params[4])? $params[4] : null;
$p3 = isset($params[5])? $params[5] : null;

// die('Les paramètres sont => '.$folder.' -- '.$controller.' -- '.$action.' -- '.$p1.'-- '.$p2.' -- '.$p3.' -- '.sizeof($params).' ');

require('./Controllers/'.$folder.'/'.$controller.'.php');
$controller= new $controller();
// Vérifier pour paramètres 
if(empty(array_slice($params,3))){
    if(method_exists($controller,$action)){
        $controller->$action();
    }
    else{
        require('Views/Errors/404_view.php');
    }
}else{
    if(method_exists($controller,$action)){
        $controller->$action(array_slice($params,3));
    }
    else{
        require('Views/Errors/404_view.php');
    }
}


// ErrorDocument 400 "<h1>404 Error</h1><p>Page not found...</p>"
// ErrorDocument 500 "<h1>500 Error</h1><p>Page not found...</p>"
?>