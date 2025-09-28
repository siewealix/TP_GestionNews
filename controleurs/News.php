<?php
class News {
    private $id;
    private $auteur;
    private $titre;
    private $contenu;
    private $dateAjout;
    private $dateModif;

    // Constructeur
    public function __construct($id, $auteur, $titre, $contenu, $dateAjout, $dateModif) {
        $this->id = $id;
        $this->auteur = $auteur;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->dateAjout = $dateAjout;
        $this->dateModif = $dateModif;
    }

    // Accesseurs
    public function getId() {
        return $this->id;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDateAjout() {
        return $this->dateAjout;
    }

    public function getDateModif() {
        return $this->dateModif;
    }

    // Mutateurs
    public function setId($id) {
        $this->id = $id;
    }

    public function setAuteur($auteur) {
        $this->auteur = $auteur;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;
    }

    public function setDateModif($dateModif) {
        $this->dateModif = $dateModif;
    }
}

?>