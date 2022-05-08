<?php

namespace Projet_Web_parcours\Models;

use \PDO;
use \PDOException;

    class Connexion {

        private $login;
        private $pass;
        private $db;
        private static $connec;
        private function __construct($db ='test2', $login ='root', $pass=''){
            $this->login = $login;
            $this->pass = $pass;
            $this->db = $db;
            $this->connexion();
        }


        private function connexion(){
            try
            {
                self::$connec = new PDO(
                                'mysql:host=localhost;dbname='.$this->db.';charset=utf8mb4', 
                                $this->login, 
                                $this->pass
                );
                self::$connec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                self::$connec->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }
            catch (PDOException $e)
            {
                $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
                die($msg);
            }
        }

        //Singleton. Si l'instance de la classe existe, elle est retounée, si non elle est crée et retournée.

        static public function getInstance()
        {
            if(self::$connec === NULL){
                new Connexion();
            }
            return self::$connec;
        }

        //TODO Inspiration pour créer la classe model mère
        // public function q($sql,Array $cond = null){
        //     $stmt = $this->connec->prepare($sql);

        //     if($cond){
        //         foreach ($cond as $v) {
        //             $stmt->bindParam($v[0],$v[1],$v[2]);
        //         }
        //     }

        //     $stmt->execute();

        //     return $stmt->fetchAll();
        //     $stmt->closeCursor();
        //     $stmt=NULL;
        // }
    }

?>