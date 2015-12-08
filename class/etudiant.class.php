<?php

Class Etudiant extends Utilisateur{

   // Curriculum vitae
	private $_cv;

   // Lettre de motivation
	private $_lettre;

   // Listes des offres de stage auquel l'étudiant à postuler.
	private $_offres;

     /**
     * Constructeur d'un etudiant
     */
	private function __construct($nom, $prenom, $mail, $adresse, $id){
		$this->_nom = $nom;
		$this->_prenom = $prenom;
		$this->_mail = $mail;
		$this->_adresse = $adresse;
		$this->_id = $id;
		$this->_offres = array();
	}


	/** 
	* Ajoute un stage à la listes des candidatures de l'étudiant.
	* La BD est aussi mise à jour.
	* @param s stage à rajouter.
	 */

	public function postulerStage($s){
		$pdo = myPDO::getInstance();
		$pdo->prepare(<<<SQL

SQL
	);
		$pdo->execute(array());
		return false;
	}


	/**
	 *Ajoute un Etudiant dans la base de donéees
	 * 
	 */	

	function inscription($nom, $prenom, $adresse=null, $ville=null, $cp=null, $mail,
	       				$login=null,$pass =null){
		$res = false;
		$pdo = myPDO::getInstance() ;
		
		$query = $pdo->prepare(<<<SQL
					SELECT count(numEtudiant) as nb
					FROM Etudiant
					WHERE nom = ?
					AND prenom =?
					AND mail = ?
SQL
		);
		$nb = $query->execute(array($nom, $prenom, $mail));
		$nb = $nb->fetch();
		
		if($nb['nb']==0){
			$stmt = $pdo->prepare(<<<SQL
					INSERT INTO Etudiant()
						VALUES ()
SQL
			);
		
			$res = $stmt->execute(array($nom,$prenom,$adresse,$ville,$cp,$mail,$login,$pass));
		}
		return $res;
	}

}
