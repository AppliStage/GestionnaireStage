<?php
include_once "../myPDO.include.php";

abstract class Utilisateur{
	
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

	// Telephone de l'utilisateur
	protected $_tel;

	
	/**
	 * Constructeur d'un utilistateur
	 */

	function __construct(){

	}
	
	
	/**
	 * Cherche dans la table "Utilisateur" un enregistrement pour lequel le
	 * login et le mot de passe correspondes aux paramêtres.
	 * @param login
	 * @param password
	 * @return Renvoi true si l'utilisateur c'est connecté, false sinon.
	 */
	//abstract function auth($login, $pass);
	
	/**
	 * Vérifie le contenu des attributs et enregistre l'utilisateur si
	 * il n'exite pas déjà.
	 * @return Renvoie true si l'utilisateur a pu s'inscrire, false sinon.
	 */
	//abstract function inscription($nom, $prenom, $mail, $pass =null, $tel = null,$adresse=null, $fonction=null);
	
	
	// Les getters de la foliiiiiiiie !!!!!

	public function getNom(){
		return $this->_nom;
	}
	
	public function getPrenom(){
		return $this->_prenom;
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function getMail(){
		return $this->_mail;
	}
	
	public function getAdresse(){
		return $this->_adresse;
	}

	public function getTel(){
		return $this->tel;
	}
	
} 
