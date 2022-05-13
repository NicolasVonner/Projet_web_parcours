<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Position extends Model
    {
        //Ajoute un parcour dans la base.
        public static function persistPosition($position){  
           return Model::insert("position", $position->to_Array());          
        }

        //Vérifie si la position existe dans la base, et la renvoie.
        public static function existPosition($where, $what = null){ 
           return isset($what)? Model::select(table: "position", param_what: $what, param_where: $where):
           Model::select(table: "position", param_where: $where);        
        }
    }