<?php

namespace Projet_Web_parcours\Entities;

class Team
{
    private $codeE;
    private $nomE;
    private $dateCrea;
    private $codeCreateur;
   private $emblemE;
   

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
    public function getCodeE()
    {
        return $this->codeE;
    }
    public function setCodeE($new_codeE)
    {
        $this->codeM = $new_codeE;
    }

    public function getNomE()
    {
        return $this->nomE;
    }
    public function setNomE($new_nom)
    {
        $this->nomE = $new_nom;
    }

    public function getdateCrea	()
    {
        return $this->dateCrea	;
    }
    public function setdateCrea	($new_date)
    {
        $this->dateCrea	 = $new_date;
    }
    
    public function getcodeCreateur	()
    {
        return $this->codeCreateur;
    }
    public function setcodeCreateur	($new_codeCreateur)
    {
        $this->codeCreateur = $new_codeCreateur;
    }

    
    public function getEmblemE()
    {
        return $this->emblemE;
    }
    public function setEmblemE($new_emblem)
    {
        $this->emblemE = $new_emblem;
    } 

    

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return !isset($this->codeM)? 'Equipe =>' . $this->getNomE() . '/'. $this->getDateInscription() . '/':
                                     'Equipe =>' . $this->getCodeE() . '/'. $this->getNomE() . '/' . $this->getDateInscription() . '/';
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return !isset($this->codeE)? array (
                                          'nomE' => $this->getNomE(),
                                        'dateCrea' => $this->getdateCrea(),
                                        'codeCreateur'=> $this->getcodeCreateur(),
                                        'emblemE'=>$this->getEmblemE(),
                                    ):
                                    array (
                                        'codeE' => $this->getCodeE(),
                                        'nomE' => $this->getNomE(),
                                        'dateCrea' => $this->getdateCrea(),
                                        'codeCreateur'=> $this->getcodeCreateur(),
                                        'emblemE'=>$this->getEmblemE(),
                                    );
    }
    
}
