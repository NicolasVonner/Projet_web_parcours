<?php

namespace Projet_Web_parcours\Entities;

class Course
{
    private $codePa;
    private $createur;
    private $nomPa;
    private $descriptionPa;
    private $dateCreation;
    private $dateDerniereModif;
    private $hashCode;
    private $activation;

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
    public function getCodePa()
    {
        return $this->codePa;
    }
    public function setCodePa($new_codePa)
    {
        $this->codePa = $new_codePa;
    }

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

    public function getDescriptionPa()
    {
        return $this->descriptionPa;
    }
    public function setDescriptionPa($new_descriptionPa)
    {
        $this->descriptionPa = $new_descriptionPa;
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

    public function getActivation()
    {
        return $this->activation;
    }
    public function setActivation($new_activation)
    {
        $this->activation = $new_activation;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return !isset($this->codePa)? 'Parcour =>' . $this->getCreateur() . '/' . $this->getNomPa() . '/' . $this->getDescriptionPa() . '/' . $this->getDateCreation() . '/' . $this->getDateDerniereModif() . '/' .$this->getHashCode():
            'Parcour =>' . $this->getCodePa() . '/' .$this->getCreateur() . '/' . $this->getNomPa() . '/' . $this->getDescriptionPa() . '/' . $this->getDateCreation() . '/' . $this->getDateDerniereModif() . '/' .$this->getHashCode(). '/' .$this->getActivation();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return !isset($this->codePa)?
            array (
                'createur' => $this->getCreateur(),
                'nomPa' => $this->getNomPa(),
                'descriptionPa' =>$this->getDescriptionPa(),
                'dateCreation' => $this->getDateCreation(),
                'dateDerniereModif' => $this->getDateDerniereModif(),
                'hashCode' => $this->getHashCode(),
            ):
            array (
                'codePa' => $this->getCodePa(),
                'createur' => $this->getCreateur(),
                'nomPa' => $this->getNomPa(),
                'descriptionPa' =>$this->getDescriptionPa(),
                'dateCreation' => $this->getDateCreation(),
                'dateDerniereModif' => $this->getDateDerniereModif(),
                'hashCode' => $this->getHashCode(),
                'activation' => $this->getActivation()
            );
    }
    
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceCourseArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
