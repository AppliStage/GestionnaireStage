<?php

include_once "commentaire.class.php";
include_once "stage.class.php";
include_once "myPDO.include.php";

class Entreprise {
   
   private $nom;
   private $tel;
   private $adresse;
   private $typeJuridique;
   private $site;
   private $ville;
   private $pays;
   private $SIRET;
   private $SIREN;
   private $codeAPE;
   private $logo;
   private $avis =  array(); // Liste des commentaire laissé par les enseignants
   private $stages =  array(); //Liste des offre de l'entreprise.
   private $entrepreneur;
   private $codePostal;
   
   /**
    * Constructeur d'une entreprise,
    * La liste des Avis et des stages sont défini si l'entreprise exist dans la BD.
    */
    public function __construct($siret, $nom, $adresse, $tel, $type, $ville, $pays, $siren, $codeAPE, $entrepreneur, $codePostal, $logo = null) {

        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->tel = $tel;
        $this->typeJuridique = $type;
        $this->$ville = $ville;
        $this->pays = $pays;
        $this->SIRET = $siret;
        $this->SIREN = $siren;
        $this->codeAPE = $codeAPE;
        $this->logo = $logo;
        $this->numEntreneur = $entrepreneur;
        $this->avis[] = Comentaire::getAll($this->SIRET);
        $this->stages[] = Stage::getAll($this->SIRET);
        $this->codePostal = $codePostal;

        return $this;
    }

   /** 
    * Ajoute un stage à la liste des offres de l'entreprise
    * @param s
    */
    public function ajouterOffre( $s) {
        $this->stages[] = $s;
    }

    /**
     * Sauvegarde l'entreprise dans la base de donnée.
     * @return true si l'entreprise à été enregisté, false sinon
     */
    public function save(){
        $pdo = myPDO::getInstance();
        $req1 = $pdo->prepare(<<<SQL
            INSERT INTO Entrepreprise (SIRET, nom, tel, adresse, typeJuridique,site, ville, pays, SIREN, codeAPE, logo, numEntreneur,codePostal)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)
SQL
        );
        $ins = $req1->execute(array( $this->SIRET, $this->nom, $this->tel, $this->adresse, $this->typeJuridique, 
          $this->site, $this->ville, $this->pays, $this->SIREN, $this->codeAPE, $this->logo, $this->numEntreneur, $this->codePostal));

        return $ins;
    }
   
   /** 
    * Supprime l'offre de stage passer en parametre 
    * @param s id du stage à supprimer
    * @return True si l'offre à été supprimer, false sinon.
    */
	public function supprOffre($s) {      
        unset($this->_stages[$s]);
	}

}
