<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Note extends Model
    {     
        //Vérifie si une note de l'utilisateur existe déjà.
        public static function existNote($where, $what = null){  
           return isset($what)? Model::select(table: "note", param_what: $what, param_where: $where):
           Model::select(table: "note", param_where: $where);        
        }

        //Ajoute une note dans la table note.
        public static function persistNote($note){  
           Model::insert("note", $note->to_Array());          
        }

        //suprimer un note
        //appeller quand on suprime un parcour dans le parcour controller
        public static function deleteNote($where){ 
         Model::delete("note", params_where: $where);       
      }

    }