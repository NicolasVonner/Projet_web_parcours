<?php
session_start();
// TODO quand on met les controllers dans un namespace, l'intanciation dans l'index
//ci desous ne marche plus donc pas de namepace pour les controllers pour l'instant
//car ce sont les seuls fichiers à etre appeler par le routeur.
define("WEBROOT", str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define("ROOT", str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

//Autoload
spl_autoload_register(function ($class_name) {
    //TODO Gérer la disection pour les vues, pour l'instant elles sont required comme ça 
    //On vérifie le type du fichier à charger pour le nom de classe qui diffère du nom de fichier.
    $path = explode('\\',$class_name);
    if(!isset($path[1]))
    die("=====>".var_dump($class_name));
    //On retire le nom du projet. 
    $path = array_slice($path, 1);

    if($path[0] == 'Entities'){
        $path[1] .= '_entity';
    }else if($path[0] == 'Models'){
       $path[1]!='Model'? $path[1] .= '_model': true;
    }
    else if($path[0] == 'Assets'){
        if($path[1] == 'enums')
          $path[3] .= '_enum';
          else if($path[1] == 'settings'){
            $path[2] .= '_conf';
            //die("===>".var_dump($path));
          }
    }
    else if($path[0] == 'Controllers'){
        $type = explode('_',$path[1]);
        array_splice($path, 1, 0, $type[0]);
    }
    //Assemblage du chemin complet et appel du fichier.
    $file = implode("\\",$path).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});
//die("===>".$_GET['p']);
//TODO A modifier, ici on met les valeurs à null si on désire taper sur la racine.
if(sizeof(explode('/',$_GET['p'])) == 1){
    $params = ["", null, null, null, null, null];
}else{
    $params = explode('/',$_GET['p']);
}
$folder= empty(!$params[0])? $params[0] : 'Main';
$controller= isset($params[1])? $params[1] : 'Index_controller';
$action = isset($params[2])? $params[2] : 'rootDirection';
$p1 = isset($params[3])? $params[3] : null;
$p2 = isset($params[4])? $params[4] : null;
$p3 = isset($params[5])? $params[5] : null;
// die('Les paramètres sont => '.$folder.' -- '.$controller.' -- '.$action.' -- '.$p1.'-- '.$p2.' -- '.$p3.' -- '.sizeof($params).' ');
//On verifie si une mauvaise URL est rentrée
file_exists('./Controllers/'.$folder.'/'.$controller.'.php')?
    require('./Controllers/'.$folder.'/'.$controller.'.php'):
    require('Views/Errors/404_view.php');

//On instancie le controller
$controller = new $controller();

method_exists($controller,$action)? paramVerifier($controller, $params, $action) : require('Views/Errors/404_view.php');

//TODO Nimporte quelle fonction peut recevoir nimporte quels params
// Vérifier pour paramètres 
function paramVerifier($controller, $parameters, $method){
    empty(array_slice($parameters, 3))? $controller->$method(): $controller->$method(array_slice($parameters,3));
}