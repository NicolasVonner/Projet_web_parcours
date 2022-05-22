<?php

namespace Projet_Web_parcours\Entities;

class HistoParcour
{
    private $joueur;
    private $parcour;
    private $step;
    private $position;
    private $time;

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
    public function getJoueur()
    {
        return $this->joueur;
    }
    public function setJoueur($new_joueur)
    {
        $this->joueur = $new_joueur;
    }

    public function getParcour()
    {
        return $this->parcour;
    }
    public function setParcour($new_parcour)
    {
        $this->parcour = $new_parcour;
    }

    public function getStep()
    {
        return $this->step;
    }
    public function setStep($new_step)
    {
        $this->step = $new_step;
    }

    
    public function getPosition()
    {
        return $this->position;
    }
    public function setPosition($new_position)
    {
        $this->position = $new_position;
    }

    public function getTime()
    {
        return $this->time;
    }
    public function setTime($new_time)
    {
        $this->time = $new_time;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'Historique parcour => ' . $this->getJoueur() . '/' . $this->getParcour() . '/' . $this->getStep(). '/'.  $this->getPosition(). '/' . $this->getTime();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return array (
            'joueur' => $this->getJoueur(),
            'parcour' => $this->getParcour(),
            'step' => $this->getStep(),
            'position' => $this->getPosition(),
            'time' => $this->getTime(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceActivityArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
