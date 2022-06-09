<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Equipe extends Model
    {
        // Vérifie l'email ou le username existe déja dans la base lors de l'inscription.
        public static function redundancyUser($what, $where){  
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
        
        //Vérifie si l'utilisateur existe dans la base, et le renvoie.
        public static function existEquipe($where, $what = null){  
           return isset($what)? Model::select(table: "equipe", param_what: $what, param_where: $where):
           Model::select(table: "equipe", param_where: $where);        
        }

        //Ajoute un utilisateur.
        public static function persistUser($user){  
           Model::insert("equipe", $user->to_Array());          
        }

        //Met à jour un utilisateur.
        public static function updateUser($what, $where){ 
           Model::update(table: "equipe", params_what: $what, params_where: $where);       
        }
    }