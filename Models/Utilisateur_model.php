<?php
require('./connexion_model.php');
    class Utilisateur extends Connexion
    {

        //Methodes d'affichage de l'objet
        public function to_String() : string{
            return 'Utilisateur =>'.$this->nomM .'/'. $this->prenomM .'/'. $this->adressMail .'/'. $this->dateInscription .'/'. $this->dateNaissance .'/'. $this->badgeCrea .'/'. $this->badgeAv;
        } 
        public function __toString ( ) : string{
            return $this->to_String();
        }   

        //Créer le pdo dans le constructeur Utilisateur
        function createUser($database){  
            $connect = Connexion::getInstance($database);   
            $connect->query('INSERT INTO membre VALUES (jose, anigo, jose.anigo@gmail.com, '.date("d-m-Y").','.date("d-m-Y").',Novice, Marcheur_du_dimanche)');
        }
    
        function updateUserbadgeCrea($database, $id, $badgeCRea){  
            $connect = Connexion::getInstance($database);   
            $connect->query('UPDATE `membre`
            SET badgeCrea='.$badgeCRea.', column2=value2,...
            WHERE codeM='.$id);
        }
    
        function deleteUser($database, $nom ){  
            $connect = Connexion::getInstance($database);   
            $connect->query('DELETE FROM `membre` WHERE nomM = '.$nom);
        }
    }