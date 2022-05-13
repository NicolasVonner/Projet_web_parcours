<?php

namespace Projet_Web_parcours\Entities;

class Jeu_texte
{
    private $devinette;
    private $reponse;
    private $indice;
    private $choix_1;
    private $choix_2;
    private $choix_3;
    private $choix_4;

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
    public function getDevinette()
    {
        return $this->devinette;
    }
    public function setDevinette($new_devinette)
    {
        $this->devinette = $new_devinette;
    }

    public function getReponse()
    {
        return $this->reponse;
    }
    public function setReponse($new_reponse)
    {
        $this->reponse = $new_reponse;
    }

    public function getIndice()
    {
        return $this->indice;
    }
    public function setIndice($new_indice)
    {
        $this->indice = $new_indice;
    }

    public function getchoix_1()
    {
        return $this->choix_1;
    }
    public function setchoix_1($new_choix_1)
    {
        $this->choix_1 = $new_choix_1;
    }

    public function getchoix_2()
    {
        return $this->choix_2;
    }
    public function setchoix_2($new_choix_2)
    {
        $this->choix_2 = $new_choix_2;
    }

    public function getchoix_3()
    {
        return $this->choix_3;
    }
    public function setchoix_3($new_choix_3)
    {
        $this->choix_3 = $new_choix_3;
    }

    public function getchoix_4()
    {
        return $this->choix_4;
    }
    public function setchoix_4($new_choix_4)
    {
        $this->choix_4 = $new_choix_4;
    }


    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'Gametext =>' . $this->getDevinette() . '/' . $this->getReponse(). '/' . $this->getIndice() . '/' . $this->getchoix_1() . '/' . $this->getchoix_2() . '/' . $this->getchoix_3() . '/' . $this->getchoix_4();
    }

    //Tranforme l'objet en tableau associatif (Gametext, default null)
    public function to_Array(): array{
        return array (
            'devinette' => $this->getDevinette(),
            'reponse' => $this->getReponse(),
            'indice' => $this->getIndice(),
            'choix_1' => $this->getchoix_1(),
            'choix_2' => $this->getchoix_2(),
            'choix_3' => $this->getchoix_3(),
            'choix_4' => $this->getchoix_4(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceActivityArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}
