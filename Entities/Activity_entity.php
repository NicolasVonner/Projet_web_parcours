<?php

namespace Projet_Web_parcours\Entities;

class Activity
{
    private $position;
    private $typejeu;
    private $gameId;

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
    public function getPosition()
    {
        return $this->position;
    }
    public function setPosition($new_position)
    {
        $this->position = $new_position;
    }

    public function getTypeJeu()
    {
        return $this->typejeu;
    }
    public function setTypeJeu($new_typejeu)
    {
        $this->typejeu = $new_typejeu;
    }

    public function getGameId()
    {
        return $this->gameId;
    }
    public function setGameId($new_gameId)
    {
        $this->gameId = $new_gameId;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'Activite =>' . $this->getPosition() . '/' . $this->getTypeJeu() . '/' . $this->getGameId();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return array (
            'position' => $this->getPosition(),
            'typejeu' => $this->getTypeJeu(),
            'gameId' => $this->getGameId(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceActivityArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
