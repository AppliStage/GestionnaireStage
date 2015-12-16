<?php

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
	
	const session_key = "__user__";

	
	/**
	 * Constructeur d'un utilistateur
	 */

	function __construct(){

	}
	
	
   /**
    * Démarrer une session
    * @throws SessionException si la session ne peut être démarrée
    *
    * @return void
    */
    protected static function startSession() {
        // Vision la plus contraignante et donc la plus fiable
        // Si les en-têtes ont deja été envoyés, c'est trop tard...
        if (headers_sent())
            throw new SessionException("Impossible de démarrer une session si les en-têtes HTTP ont été envoyés") ;
        // Si la session n'est pas demarrée, le faire
        if (!session_id()) 
        	session_start() ;
    }



	public static function isConnected() {
		$rep=false;
		self::startSession();
		if(isset($_SESSION[self::session_key])){
			if (isset($_SESSION[self::session_key]['connected']) && $_SESSION[self::session_key]['connected'] ==true)
				$rep=true;
		}
		return $rep;
		
	}
	
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
