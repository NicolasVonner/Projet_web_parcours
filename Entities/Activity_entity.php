<?php

namespace Projet_Web_parcours\Entities;

class Activity
{
    private $codeAct;
    private $position;
    private $activiteType;
    private $activite;

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
    public function getCodeAct()
    {
        return $this->codeAct;
    }
    public function setCodeAct($new_codeAct)
    {
        $this->codeAct = $new_codeAct;
    }

    public function getPosition()
    {
        return $this->position;
    }
    public function setPosition($new_position)
    {
        $this->position = $new_position;
    }

    public function getActiviteType()
    {
        return $this->activiteType;
    }
    public function setActiviteType($new_activiteType)
    {
        $this->activiteType = $new_activiteType;
    }

    public function getActivite()
    {
        return $this->activite;
    }
    public function setActivite($new_activite)
    {
        $this->activite = $new_activite;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return !isset($this->codeAct)? 'Activite =>' . $this->getPosition() . '/' . $this->getActiviteType() . '/' . $this->getActivite()
        :'Activite =>' . $this->getCodeAct() . '/' . $this->getPosition() . '/' . $this->getActiviteType() . '/' . $this->getActivite();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return !isset($this->codeAct)? array (
            'position' => $this->getPosition(),
            'activiteType' => $this->getActiviteType(),
            'activite' => $this->getActivite(),
        )
        :array (
            'codeAct' => $this->getCodeAct(),
            'position' => $this->getPosition(),
            'activiteType' => $this->getActiviteType(),
            'activite' => $this->getActivite(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceActivityArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
