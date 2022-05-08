<?php

namespace Projet_Web_parcours\Models;

use \Exception;

    class Position extends Model
    {
        //Ajoute un parcour dans la base.
        public static function persistPosition($position){  
           return Model::insert("position", $position->to_Array());          
        }
    }