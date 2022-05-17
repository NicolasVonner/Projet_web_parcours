<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Activite extends Model
    {
        //Partie de traitement sur les types de jeux.

        //Vérifie si le type d'activité existe dans la bases et retourne les arguments.
        public static function existActivityType($where, $what = null){ 
            return isset($what)? Model::select(table: "typeactiv", param_what: $what, param_where: $where):
            Model::select(table: "typeactiv", param_where: $where);        
        }

        //Partie de traitement sur les activités rescencées.

        //Vérifie si l'activité existe dans la bases et la retourne
        public static function existActivity($where, $what = null){ 
            return isset($what)? Model::select(table: "activite", param_what: $what, param_where: $where):
            Model::select(table: "activite", param_where: $where);        
        }

        //Ajoute une activite dans la base.
        public static function persistActivite($activite){  
            Model::insert("activite", $activite->to_Array());          
         }

        //Supprime une activité game.
         public static function deleteActivite($where){ 
            Model::delete("activite", params_where: $where);       
         }

         //Partie de traitement sur les jeux en eux même

        //Ajoute une activiteGame dans la base parmis les types jeu_test / jeu_image / jeu_choix.
        public static function persistActiviteGame($type, $activiteGame){  
            return Model::insert($type, $activiteGame->to_Array());          
         }

        //Récupère l'activité dans la base parmis les types jeu_test / jeu_image / jeu_choix.
        public static function existActiviteGame($type, $where, $what = null){  
            return Model::select(table: $type, param_what: $what, param_where: $where);       
         }
        
        //Récupère les attributs d'une activité game.
        public static function getActivityGameParams($activity){ 
            return  Model::select('SHOW COLUMNS FROM '.$activity);        
        }

        //Met à jour une activité game. 
        public static function updateActiviteGame($table, $what, $where){ 
           Model::update(table: $table, params_what: $what->to_Array(), params_where: $where);       
        }

         //Supprime une activité game.
         public static function deleteActiviteGame($table, $where){ 
            Model::delete($table, params_where: $where);       
         }
        
        //Partie de traitement sur l'historique des activités.

        //Supprime un historique.
        public static function deleteActiviteHisto($where){ 
            Model::delete("historique_activ", params_where: $where);       
         }
    }