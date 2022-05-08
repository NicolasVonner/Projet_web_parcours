<?php

namespace Projet_Web_parcours\Entities;

class Course
{
    private $createur;
    private $nomPa;
    private $dateCreation;
    private $dateDerniereModif;
    private $hashCode;

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
    public function getCreateur()
    {
        return $this->createur;
    }
    public function setCreateur($new_createur)
    {
        $this->createur = $new_createur;
    }

    public function getNomPa()
    {
        return $this->nomPa;
    }
    public function setNomPa($new_nomPa)
    {
        $this->nomPa = $new_nomPa;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }
    public function setDateCreation($new_dateCreation)
    {
        $this->dateCreation = $new_dateCreation;
    }

    public function getDateDerniereModif()
    {
        return $this->dateDerniereModif;
    }
    public function setDateDerniereModif($new_dateDerniereModif)
    {
        $this->dateDerniereModif = $new_dateDerniereModif;
    }

    public function getHashCode()
    {
        return $this->hashCode;
    }
    public function setHashCode($new_hashCode)
    {
        $this->hashCode = $new_hashCode;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }
    public function setDateInscription($new_dateInscription)
    {
        $this->dateInscription = $new_dateInscription;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'Parcour =>' . $this->getCreateur() . '/' . $this->getNomPa() . '/' . $this->getDateCreation() . '/' . $this->getDateDerniereModif() . '/' .$this->getHashCode();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return array (
            'createur' => $this->getCreateur(),
            'nomPa' => $this->getNomPa(),
            'dateCreation' => $this->getDateCreation(),
            'dateDerniereModif' => $this->getDateDerniereModif(),
            'hashCode' => $this->getHashCode(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceCourseArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
