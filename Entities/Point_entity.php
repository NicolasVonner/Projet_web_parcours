<?php

namespace Projet_Web_parcours\Entities;

class Point
{
    private $parcour;
    private $nomPo;
    private $pays;
    private $latitude;
    private $longitude;

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
    public function getParcour()
    {
        return $this->parcour;
    }
    public function setParcour($new_parcour)
    {
        $this->parcour = $new_parcour;
    }

    public function getNomPo()
    {
        return $this->nomPo;
    }
    public function setNomPo($new_nomPo)
    {
        $this->nomPo = $new_nomPo;
    }

    public function getPays()
    {
        return $this->pays;
    }
    public function setPays($new_pays)
    {
        $this->pays = $new_pays;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLatitude($new_latitude)
    {
        $this->latitude = $new_latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setLongitude($new_longitude)
    {
        $this->longitude = $new_longitude;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'Position =>'. $this->getParcour() . '/' . $this->getNomPo() . '/' . $this->getPays() . '/' . $this->getLatitude() . '/' . $this->getLongitude();
    }

    //Tranforme l'objet en tableau associatif
    public function to_Array(): array{
        return array (
            'parcour' => $this->getParcour(),
            'nomPo' => $this->getNomPo(),
            'pays' => $this->getPays(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reducePointArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
