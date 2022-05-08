<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Activite extends Model
    {
        //Ajoute un parcour dans la base.
        public static function persistPosition($activite){  
           Model::insert("activite", $activite->to_Array());          
        }
    }