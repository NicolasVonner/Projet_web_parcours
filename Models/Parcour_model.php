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

        //Met à jour un parcour.
        public static function updateParcour($what, $where){ 
           Model::update(table: "parcour", params_what: $what->to_Array(), params_where: $where);       
        }

         //Supprime un parcour.
        public static function deleteParcour($where){ 
           Model::delete("parcour", params_where: $where);       
        }

        //Historique parcour

         //Vérifie si le parcour existe dans la base, et le renvoie.
        public static function existParcourHisto($where, $what = null){ 
           return isset($what)? Model::select(table: "historique_parcour", param_what: $what, param_where: $where):
           Model::select(table: "historique_parcour", param_where: $where);        
        }
    }