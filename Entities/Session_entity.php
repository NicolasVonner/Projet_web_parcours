<?php

namespace Projet_Web_parcours\Entities;

class Session {
    private $identifiant;
    private $password;

    //Constructeur
    function __construct($datas){
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

        //Acesseur / Mutateur
        public function getIdentifiant()
        {
            return $this->identifiant;
        }
        public function setIdentifiant($new_identifiant)
        {
            $this->identifiant = $new_identifiant;
        }

        public function getPassword()
        {
            return $this->password;
        }
        public function setPassword($new_pass)
        {
            $this->password = $new_pass;
        }

        //Methodes d'affichage de l'objet
        public function __toString(): string{
            return 'Session =>' . $this->getIdentifiant() . '/' . $this->getPassword();
        }

        public function to_Array(): array{
            return filter_var($this->getIdentifiant(), FILTER_VALIDATE_EMAIL)? array('adresseMail' => $this->getIdentifiant(),'password' => $this->getPassword()): array('username' => $this->getIdentifiant(),'password' => $this->getPassword());
        }

        //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
        public function reduceSessionArray($offset, $length): array{
            return array_slice($this->to_Array(),$offset,$length);
        }
}