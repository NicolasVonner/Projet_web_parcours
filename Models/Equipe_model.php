<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Equipe extends Model
    {
        //todo
        // Vérifie l'email ou le username existe déja dans la base lors de l'inscription de l'équipe.
        public static function redundancyEquipe($what, $where){  
            $result = array();
            foreach ($where as $attibute => $value) {
                $stmt = Model::select(table: "equipe", param_what: $what, param_where: array($attibute => $value));
                $count = (int)$stmt->fetch()->utilisateur;
                if($count != 0){
                    $result = array_merge($result, array($attibute => $value));
                }
            }
            return empty($result) ? false : $result;                
        }
        
        //Vérifie si l'equipe existe dans la base, et le renvoie.
        public static function existEquipe($where, $what = null){  
           return isset($what)? Model::select(table: "equipe", param_what: $what, param_where: $where):
           Model::select(table: "equipe", param_where: $where);        
        }

        //Ajoute une équipe.
        public static function persistEquipe($equipe){  
           Model::insert("equipe", $equipe->to_Array());          
        }

        //Met à jour une equipe.
        public static function updateEquipe($what, $where){ 
           Model::update(table: "equipe", params_what: $what, params_where: $where);       
        }

        
         //suprimer une equipe, fonctionalité reservée au créateur de l'équipe
         public static function deleteEquipe($where){ 
            Model::delete("equipe", params_where: $where);       
         }
    }