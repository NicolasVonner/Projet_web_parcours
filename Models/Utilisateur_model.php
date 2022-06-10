<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Utilisateur extends Model
    {
        // Vérifie l'email ou le username existe déja dans la base lors de l'inscription.
        public static function redundancyUser($what, $where){  
            $result = array();
            foreach ($where as $attibute => $value) {
                $stmt = Model::select(table: "membre", param_what: $what, param_where: array($attibute => $value));
                $count = (int)$stmt->fetch()->utilisateur;
                if($count != 0){
                    $result = array_merge($result, array($attibute => $value));
                }
            }
            return empty($result) ? false : $result;                
        }
        
        //Vérifie si l'utilisateur existe dans la base, et le renvoie.
        public static function existUser($where, $what = null){  
           return isset($what)? Model::select(table: "membre", param_what: $what, param_where: $where):
           Model::select(table: "membre", param_where: $where);        
        }

        //Renvoie tous les utilisateurs.
        public static function existUserAll(){  
            return Model::select(table: "membre");        
        }

        //Ajoute un utilisateur.
        public static function persistUser($user){  
           Model::insert("membre", $user->to_Array());          
        }

        //Met à jour un utilisateur.
        public static function updateUser($what, $where){ 
           Model::update(table: "membre", params_what: $what, params_where: $where);       
        }
    }