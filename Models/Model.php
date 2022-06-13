<?php

namespace Projet_Web_parcours\Models;

use \Exception;
use \PDOStatement;



class Model extends Connexion{ 
        //TODO Permettre les IN et les OR ou pas 
        //@params   
        //$param_what => Array(nom, prenom, dateNaissance, ...) DEFAULT String null (Pour vérifier params en plus du count)        
        //$table => String ou Array(membre => null, join => Join::INNER_JOIN->value, parcours => array(IdM, NomCreateur), historique_jeu => array(IdM, joueur))
        //$param_where => Array(name => nicolas, surname => nico, adress => 55 chemin des framboises)
        //$param_group => String, membre
        public static function select($request = null, $table = "null", $param_what = "*", $param_where = null, $param_group = null, $param_having = null, $param_order = null ){
            $array_prepare = [];
            if(isset($request)){
                //TODO Peut etre faire une préparée quand meme.
                $sql = $request;
                return Connexion::getInstance()->query($sql);
            }else{
                $sql = "SELECT "; 
                //On concatène les éléments à sélectionner.
                
                if(isset($param_what)){
                    //die(var_dump($param_what));
                    if(is_array($param_what)){
                        if(sizeof($param_what) == 1 && $param_what[0] == ""){
                            $sql .= "* ";
                        }else{
                            foreach ($param_what as $key => $what) {
                                $key != sizeof($param_what)-1? $sql .= $what.", " : $sql .= $what." ";   
                            }
                        }

                    }else{
                        $sql .= " * "; //todo nettoyer le model.
                    }
                   
                }else{
                    $sql .= " * "; 
                }
                //On concatène les jointures si jamais il y a plusieurs tables.
                $sql .= "FROM ";
                if(!is_array($table)){
                    $sql .= $table." ";
                }else{ 
                    $flag = false;
                    $join = "";
                    //On concatène les tables pour la jointure.
                    foreach ($table as $t => $keys_on) {
                        if(!(sizeof(explode('_',$t)) < 2)){
                            $join = $keys_on;
                            continue; 
                        }
                        if($flag == false){
                            $sql .= $t." ";
                            $flag = true;
                            continue;
                        }else{
                            $sql .= $join." ".$t;
                        }
                        if(isset($keys_on) && !empty($join)){
                            $sql .= " ON ";
                            foreach ($keys_on as $key => $champ) {
                                $key != 1? $sql .= $champ." = " : $sql .= $champ." ";                          
                            }
                        }
                    }
                }
                //On concaténe les wheres (se servir de la value pour l'execute du prepare)
                //"name" => array("nicolas"=>Operator::DIFFERENT)
                //TODO mettre les valeurs qui correspondent aux opérateurs dans un array à part au fur et à mesure OR IN
                if(isset($param_where)){
                    $flag = false;
                    $sql .= "WHERE ";
                    foreach ($param_where as $champ => $values) {
                        $sub_flag = false;
                        if($flag == false){
                            $sql .= $champ." ";  
                            $flag = true; 
                        }else{
                            $sql .= " AND ".$champ." ";
                        }
                        if(is_array($values)){
                            foreach ($values as $val=> $operator) {
                                if($sub_flag == false){
                                    $sql .= $operator."? "; 
                                    $sub_flag = true;
                                    array_push($array_prepare, $val);
                                    continue;
                                }
                                array_push($array_prepare, $val);
                                $sql .= "AND ".$champ." ".$operator."? ";
                            } 
                        }else{
                            $sql .= "= ?"; 
                            array_push($array_prepare, $values);
                        }                   
                    } 
                }
                //On concatène les group by
                if(isset($param_group)){
                    $sql .= "GROUP BY "; 
                    foreach ($param_group as $key => $group) {
                        $key != sizeof($param_group)-1? $sql .= $group.", " : $sql .= $group." "; 
                    }
                }
                //On concatène les having
                if(isset($param_having)){
                    $sql .= "HAVING "; 
                    foreach ($param_having as $champ => $value) {
                        if($flag == false){
                            $sql .= $champ." =? ";  
                            $flag = true;
                            continue;   
                        }
                        $sql .= "AND ".$champ. " =? ";                             
                    } 
                }
                
                //On concatène les order by
                if(isset($param_order)){
                    $sql .= " ORDER BY "; 
                    foreach ($param_order as $key => $value) {
                        $key != sizeof($param_order)-1? $sql .= "$value, " : $sql .= "$value ASC "; 
                    }
                }
            }
            // if($table == 'membre') die("========>".var_dump($sql). "=======>".var_dump($array_prepare));
            return self::launch($sql, $array_prepare);
        }
        
        //TODO A completer -> crud update.
        //@Param => String $request la requete
        //=> Array $params preparation de la requete
        public static function update($table, $params_what, $params_where){
            $sql = "UPDATE ".$table ;
            $values_prep = " SET ";
            //KP incrémentation auto / equipe NULL par défaut what
            foreach(array_keys($params_what) as $key){
                $key != array_key_last($params_what)?$values_prep .= $key."=?, ":$values_prep .= $key."=? ";           
            }
            //Where
            $values_prep .= 'WHERE ';
            foreach (array_keys($params_where) as $key) { 
                $values_prep .= $key."=?";
            } 
            $sql .= $values_prep;
            //On récupère les paramètres.
            $valuesSet = array_values($params_what);
            $valueWhere = array_values($params_where)[0];

            array_push($valuesSet, $valueWhere);
            self::launch($sql, $valuesSet);
        }

        public static function delete($table, $params_where){
            $sql = "DELETE FROM ".$table ;
            //Where
            $values_prep = ' WHERE ';
            foreach(array_keys($params_where) as $key){
                $key != array_key_last($params_where)?$values_prep .= $key."=?, ": $values_prep .= $key."=? ";           
            }
            $sql .= $values_prep;
            //On récupère les paramètres.
            $valuesSet = array_values($params_where);
            // die("La request update est =>".var_dump($sql)." et les paramètres sont =>".var_dump($valuesSet)); //TODO tester la fonciton et faire l'envoie
            self::launch($sql, $valuesSet);
        }

        // $sql = "INSERT INTO membre (pass, nomM, prenomM, username, adresseMail, dateInscrition, dateNaissance, equipe) VALUES (?,?,?,?,?,?,?,?,?)";
        // $stmt = Connexion::getInstance()->prepare($sql);
        // try{
        //     $stmt->execute([$params[0]->getPassword(), $params[0]->getNom(), $params[0]->getPrenom(), $params[0]->getUsername(), $params[0]->getEmail(), date("d-m-Y"), $params[0]->getDateNaissance()]);
        // } catch(Exception $e){
        //     echo 'Exception reçue : ',  $e->getMessage(), "\n";
        // }

        public static function insert($table, $params){
            $sql = "INSERT INTO ".$table." (" ;
            $values_prep = " VALUES (";
                    //KP incrémentation auto / equipe NULL par défaut
                    foreach(array_keys($params) as $key){
                        if($key != array_key_last($params)){
                            $sql .= $key .", ";
                            $values_prep .= "?, ";
                        }else{
                            $sql .= $key .")";
                            $values_prep .= "?)";
                        }              
                    }
                    $sql .= $values_prep;
            //if($table == "historique_activ") die("REQUEST ==>". $sql . "=======>".var_dump(array_values($params)));
            self::launch($sql, array_values($params));
            if($table === "parcour" || $table === "position" || explode('_',$table)[0] === "jeu") return self::launch("SELECT LAST_INSERT_ID()");
        }


        //Lance la requete préparée et retourne le résultat.
        public static function launch($request, $params = null) {
            // die(var_dump($params));
            $stmt = Connexion::getInstance()->prepare($request);
            try{
                isset($params)? $stmt->execute($params): $stmt->execute();
                return $stmt;
            }catch(Exception $e){
                echo 'Exception reçue : ',  $e->getMessage(), "\n";
            }
        } 
}