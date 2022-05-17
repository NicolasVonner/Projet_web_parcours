<?php

namespace Projet_Web_parcours\Models;

    class Position extends Model
    {
        //Ajoute une position dans la base.
        public static function persistPosition($position){  
           return Model::insert("position", $position->to_Array());          
        }

        //Vérifie si la position existe dans la base, et la renvoie.
        public static function existPosition($where, $what = null){ 
           return isset($what)? Model::select(table: "position", param_what: $what, param_where: $where):
           Model::select(table: "position", param_where: $where);        
        }

         //Met à jour une position 
        public static function updatePosition($what, $where){ 
           Model::update(table: "position", params_what: $what->to_Array(), params_where: $where);       
        }

         //Supprime une position 
        public static function deletePosition($where){ 
           Model::delete("position", params_where: $where);       
        }
    }