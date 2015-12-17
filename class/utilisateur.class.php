<?php

Class NotInSessionException extends Exception{ }

abstract class Utilisateur{
	
	// Nom de l'utilisateur
	protected $nom;
	
	// Prenom de l'utilisateur
	protected $prenom;
	
	// Id de l'utilisateur
	protected $numEntrepreneur;
	
	// Mail de l'utilisateur
	protected $mail;

	// Adresse de l'utilisateur
	protected $adresse;

	// Telephone de l'utilisateur
	protected $tel;
	
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



    /**
     * Lecture de l'objet User dans la session
     * @throws NotInSessionException si l'objet n'est pas dans la session
     *
     * @return User
     */
    static public function createFromSession() {
        // Mise en place de la session
        self::startSession() ;
        if (isset($_SESSION[self::session_key]['user'])) {

            $u = $_SESSION[self::session_key]['user'] ;
            return $u ;
        }
       	throw new NotInSessionException() ;
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
     * Déconnecter l'utilisateur
     *
     * @return void
     */
    public static function logoutIfRequested() {
        if (isset($_REQUEST['logout'])) {
            self::startSession() ;
            unset($_SESSION[self::session_key]) ;
        }
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
