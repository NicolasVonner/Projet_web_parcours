<?php

namespace App\Entity;

class User
{
    private $nomM;
    private $prenomM;
    private $username;
    private $adressMail;
    private $password;
    private $dateInscription;
    private $dateNaissance;
    private $badgeCrea;
    private $badgeAv;

    //Constructeur
    function __construct($new_nom, $new_prenom, $new_username, $new_password, $new_adresse, $new_dateInscription, $new_dateNaissance, $new_badgeCrea, $new_badgeAv)
    {
        print "Création d'un utilisateur\n";
        $this->nomM = $new_nom;
        $this->prenomM = $new_prenom;
        $this->username = $new_username;
        $this->password = $new_password;
        $this->adressMail = $new_adresse;
        $this->dateInscription = $new_dateInscription;
        $this->dateNaissance = $new_dateNaissance;
        $this->badgeCrea = $new_badgeCrea;
        $this->badgeAv = $new_badgeAv;
    }

    //Acesseur / Mutateur
    public function getNom()
    {
        return $this->nomM;
    }
    public function setNom($new_nom)
    {
        $this->nomM = $new_nom;
    }

    public function getPrenom()
    {
        return $this->prenomM;
    }
    public function setPrenom($new_prenom)
    {
        $this->prenomM = $new_prenom;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($new_usernames)
    {
        $this->username = $new_usernames;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($new_password)
    {
        $this->password = $new_password;
    }

    public function getAddress()
    {
        return $this->adressMail;
    }
    public function setAddress($new_adressMail)
    {
        $this->adressMail = $new_adressMail;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }
    public function setDateInscription($new_dateInscription)
    {
        $this->dateInscription = $new_dateInscription;
    }

    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
    public function setDateNaissance($new_dateNaissance)
    {
        $this->dateNaissance = $new_dateNaissance;
    }

    public function getBadgeCrea()
    {
        return $this->badgeCrea;
    }
    public function setBadgeCreae($new_badgeCrea)
    {
        $this->badgeCrea = $new_badgeCrea;
    }

    public function getBadgeAv()
    {
        return $this->badgeAv;
    }
    public function setBadgeAv($new_badgeAv)
    {
        $this->badgeAv = $new_badgeAv;
    }

    //Methodes d'affichage de l'objet
    public function to_String(): string
    {
        return 'Utilisateur =>' . $this->nomM . '/' . $this->prenomM . '/' . $this->adressMail . '/' . $this->dateInscription . '/' . $this->dateNaissance . '/' . $this->badgeCrea . '/' . $this->badgeAv;
    }
    public function __toString(): string
    {
        return $this->to_String();
    }
    public static function jose(): string
    {
        return "salut";
    }
}
