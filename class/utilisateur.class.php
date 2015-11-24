<?php
include_once "myPDO.include.php";

class Utilisateur{
	
	// Nom de l'utilisateur
	protected $_nom;
	
	// Prenom de l'utilisateur
	protected $_prenom;
	
	// Id de l'utilisateur
	protected $_id;
	
	// Mail de l'utilisateur
	protected $_mail;
	
	// Adresse de l'utilisateur
	protected $_adresse;
	
	/**
	 * Constructeur d'un utilistateur
	 */
	
	function __construct($nom, $prenom, $mail, $adresse){
		$this->_nom = $nom;
		$this->_prenom = $prenom;
		$this->_mail = $mail;
		$this->_adresse = $adresse;
	}
	
	
	/**
	 * Cherche dans la table "Utilisateur" un enregistrement pour lequel le
	 * login et le mot de passe correspondes aux paramêtres.
	 * @param login
	 * @param password
	 * @return Renvoi true si l'utilisateur c'est connecté, false sinon.
	 */
	function auth($login, $pass){
		
	}
	
	/**
	 * Vérifie le contenu des attributs et enregistre l'utilisateur si
	 * il n'exite pas déjà.
	 * @return Renvoi true si l'utilisateur à pu s'inscrire, false sinon.
	 */
	function inscription($nom, $prenom, $adresse, $ville, $cp, $mail, $login, $pass){
		$res = false;
		$pdo = myPDO::getInstance() ;
		
		$query = $pdo->prepare(<<<SQL
					SELECT count(IDENTIFIANT) as nb
					FROM ETUDIANT
					WHERE IDENTIFIANT = ?
					OR MAIL = ?
SQL
		);
		$nb = $query->execute(array($login, $mail));
		$nb = $nb->fetch();
		
		if($nb['nb']==0){
			$stmt = $pdo->prepare(<<<SQL
					INSERT INTO ETUDIANT(NOMPERS,PNOMPERS,ADRPERS,VILLEPERS,CPPERS,MAILPERS,IDENTIFIANT,PASSWORD)
					VALUES (?,?,?,?,?,?,?,?)
SQL
			);
		
			$res = $stmt->execute(array($nom,$prenom,$adresse,$ville,$cp,$mail,$login,$pass));
		}
		return $res;
	}
} 
