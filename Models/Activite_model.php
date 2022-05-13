<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Activite extends Model
    {
        //Vérifie si le type d'activité existe dans la bases et retourne les arguments.
        public static function existActivityType($where, $what = null){ 
            return isset($what)? Model::select(table: "typeactiv", param_what: $what, param_where: $where):
            Model::select(table: "typeactiv", param_where: $where);        
        }
        

        //Vérifie si l'activité existe dans la bases et la retourne
        public static function existActivity($where, $what = null){ 
            return isset($what)? Model::select(table: "activite", param_what: $what, param_where: $where):
            Model::select(table: "activite", param_where: $where);        
        }

        //Ajoute une activite dans la base.
        public static function persistActivite($activite){  
            Model::insert("activite", $activite->to_Array());          
         }

         //On Partie de traitement sur les jeux en eux même

        //Ajoute une activiteGame dans la base parmis les types jeu_test / jeu_image / jeu_choix.
        public static function persistActiviteGame($type, $activiteGame){  
            return Model::insert($type, $activiteGame->to_Array());          
         }
        
         //Récupère les attributs d'une activité.
        public static function getActivityGameParams($activity){ 
            return  Model::select('SHOW COLUMNS FROM '.$activity);        
         }
    }