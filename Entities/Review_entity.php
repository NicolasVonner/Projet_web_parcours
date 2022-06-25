<?php

namespace Projet_Web_parcours\Entities;

class Review
{
    private $codePa;
    private $codeM;
    private $note;
    private $commentaire;
    private $dateN;

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

    public function getCodeM()
    {
        return $this->codeM;
    }
    public function setCodeM($new_codeM)
    {
        $this->codeM = $new_codeM;
    }

    public function getNote()
    {
        return $this->note;
    }
    public function setNote($new_note)
    {
        $this->note = $new_note;
    }
    
    public function getCommentaire()
    {
        return $this->commentaire;
    }
    public function setCommentaire($new_commentaire)
    {
        $this->commentaire = $new_commentaire;
    }

    public function getDateN()
    {
        return $this->dateN;
    }
    public function setDateN($new_dateN)
    {
        $this->dateN = $new_dateN;
    }

    //Methodes d'affichage de l'objet
    public function __toString(): string{
        return 'note => ' . $this->getCodePa() . '/' . $this->getCodeM() . '/' . $this->getNote(). '/'.  $this->getCommentaire(). '/'.  $this->getDateN();
    }

    //Tranforme l'objet en tableau associatif (Equipe, default null)
    public function to_Array(): array{
        return array (
            'codePa' => $this->getCodePa(),
            'codeM' => $this->getCodeM(),
            'note' => $this->getNote(),
            'commentaire' => $this->getCommentaire(),
            'dateN' => $this->getDateN(),
        );
    }
    //Tranforme l'objet en tableau associatif en ne gardant que certains paramètres 
    public function reduceActivityArray($offset, $length): array{
        return array_slice($this->to_Array(),$offset,$length);
    }
}