<?php
namespace Projet_Web_parcours\Models;
    class Parcour extends Model
    {
        //Ajoute un parcour dans la base.
        public static function persistParcour($parcour){  
           return Model::insert("parcour", $parcour->to_Array());          
        }

        //Vérifie si le parcour existe dans la base, et le renvoie.
        public static function existParcour($where, $what = null, $order = null){       
           if(isset($what) && isset($order) ){
            return Model::select(table: "parcour", param_what: $what, param_where: $where, param_order: $order);
           }elseif(isset($what)){
            return Model::select(table: "parcour", param_what: $what, param_where: $where);
           }elseif(isset($order)){
            return Model::select(table: "position", param_what: $what, param_order: $order);
           }else{
            return Model::select(table: "parcour", param_where: $where);   
           }   
        }
        
        //Met à jour un parcour.
        public static function updateParcour($what, $where){ 
           Model::update(table: "parcour", params_what: $what->to_Array(), params_where: $where);       
        }

         //Supprime un parcour.
        public static function deleteParcour($where){ 
           Model::delete("parcour", params_where: $where);       
        }

        //Historique parcours

        //Vérifie si le parcour existe dans la base, et le renvoie.
        public static function existParcourHisto($where, $what = null, $order = null){ 
         if(isset($what) && isset($order) ){
            return Model::select(table: "historique_parcour", param_what: $what, param_where: $where, param_order: $order);
           }elseif(isset($what)){
            return Model::select(table: "historique_parcour", param_what: $what, param_where: $where);
           }elseif(isset($order)){
            return Model::select(table: "historique_parcour", param_what: $what, param_order: $order);
           }else{
            return Model::select(table: "historique_parcour", param_where: $where);   
           }          
        }

         //Supprime un historique parcour.
        public static function deleteParcourHisto($where){ 
           Model::delete("historique_parcour", params_where: $where);       
        }
        
        //Insert un historique parcour.
        public static function persistParcourHisto($historique){ 
         Model::insert("historique_parcour", $historique->to_Array());       
      }
    }