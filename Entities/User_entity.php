<?php

namespace Projet_Web_parcours\Entities;

class User
{
    private $codeM;
    private $nomM;
    private $prenomM;
    private $username;
    private $adresseMail;
    private $password;
    private $dateInscription;
    private $dateNaissance;
    private $avatar;
    private $equipe;

    //Constructeur
    function __construct($datas)
    {
        $this->hydrate($datas);
    }

    //Hydratation
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
           // One gets the setter's name matching the attribute.
           $method = 'set'.ucfirst($key);
           // If the matching setter exists
           if (method_exists($this, $method)) {
              // One calls the setter.
              $this->$method($value);
           }
        }
     }

    //Acesseurs / Mutateurs
    public function getCodeM()
    {
        return $this->codeM;
    }
    public function setCodeM($new_codeM)
    {
        $this->codeM = $new_codeM;
    }

    public function getNomM()
    {
        return $this->nomM;
    }
    public function setNomM($new_nom)
    {
        $this->nomM = $new_nom;
    }

    public function getPrenomM()
    {
        return $this->prenomM;
    }
    public function setPrenomM($new_prenom)
    {
        $this->prenomM = $new_prenom;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($new_username)
    {
        $this->username = $new_username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($new_password)
    {
        $this->password = $new_password;
    }

    public function getAdresseMail()
    {
        return $this->adresseMail;
    }
    public function setAdresseMail($new_adresseMail)
    {
        $this->adresseMail = $new_adresseMail;
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

    public function getAvatar()
    {
        return $this->avatar;
    }
    public function setAvatar($new_avatar)
    {
        $this->avatar = $new_avatar;
    }

    public function getEquipe()
    {
        return $this->equipe;
    }
    public function setEquipe($new_equipe)
    {
        $this->equipe = $new_equipe;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return !isset($this->codeM)? 'Utilisateur =>' . $this->getNomM() . '/' . $this->getPrenomM() . '/' . $this->getUsername() . '/' . $this->getAdresseMail() . '/' .$this->getPassword() . '/' . $this->getDateInscription() . '/' . $this->getDateNaissance() . '/' . $this->getAvatar() . '/' . $this->getEquipe():
                                     'Utilisateur =>' . $this->getCodeM() . '/'. $this->getNomM() . '/' . $this->getPrenomM() . '/' . $this->getUsername() . '/' . $this->getAdresseMail() . '/' .$this->getPassword() . '/' . $this->getDateInscription() . '/' . $this->getDateNaissance() . '/' . $this->getAvatar() . '/' . $this->getEquipe();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return !isset($this->codeM)? array (
                                        'nomM' => $this->getNomM(),
                                        'prenomM' => $this->getPrenomM(),
                                        'username' => $this->getUsername(),
                                        'adresseMail' => $this->getAdresseMail(),
                                        'password' => $this->getPassword(),
                                        'dateInscription' => $this->getDateInscription(),
                                        'dateNaissance' => $this->getDateNaissance(),
                                        'avatar' => $this->getAvatar(),
                                        'equipe' => $this->getEquipe(),
                                    ):
                                    array (
                                        'codeMM' => $this->getCodeM(),
                                        'nomM' => $this->getNomM(),
                                        'prenomM' => $this->getPrenomM(),
                                        'username' => $this->getUsername(),
                                        'adresseMail' => $this->getAdresseMail(),
                                        'password' => $this->getPassword(),
                                        'dateInscription' => $this->getDateInscription(),
                                        'dateNaissance' => $this->getDateNaissance(),
                                        'avatar' => $this->getAvatar(),
                                        'equipe' => $this->getEquipe(),
                                    );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceUserArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
