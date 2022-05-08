<?php

namespace Projet_Web_parcours\Models;

    class Parcour extends Model
    {
        //Ajoute un parcour dans la base.
        public static function persistParcour($parcour){  
           return Model::insert("parcour", $parcour->to_Array());          
        }

        //Vérifie si le parcour existe dans la base, et le renvoie.
        public static function existParcour($where, $what = null){ 
           return isset($what)? Model::select(table: "parcour", param_what: $what, param_where: $where):
           Model::select(table: "parcour", param_where: $where);        
        }
    }