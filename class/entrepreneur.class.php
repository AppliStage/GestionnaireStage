<?php

class Entrepreneur extends Utilisateur {
   
   // Liste des entreprises géré par l'entrepreneur
   private $_entreprises;
   private $fonction
   const session_key = "__user__";
    
    /**
     * Constructeur d'un entrepreneur
     */
    public function __construct($nom, $prenom, $mail, $adresse, $tel, $fonction) {
	    	
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->mail = $mail;
		$this->adresse = $adresse;
		$this->tel = $tel;
		$this->fonction = $fonction;
		$_entreprises = array();
		
    }
    
    private static function startSession() {
		
		$res = false;
		
		if (session_id() == "") {
		
			if (!headers_sent()) {
			
				$res = session_start();
				//$_SESSION[self::session_key]['connected'] = true;
				
			}
			
			if (!$res) {
			
				throw new SessionException();
			
			}
			
		}
		
	}
	
	public static function isConnected() {

		self::startSession();
		return isset($_SESSION[self::session_key]) && $_SESSION[self::session_key]['connected'];
		
	}
	
	public static function logoutIfRequested() {
		
		if (isSet($_POST['logout']) && self::isConnected()) {
			
			session_destroy();
			
		}
		
	}
	
	public function saveIntoSession() {
		
		$_SESSION[self::session_key]['user'] = $this;
		
	}
	
	public static function createFromSession() {
		
		self::startSession();
		
		if (isSet($_SESSION[self::session_key]) && isSet($_SESSION[self::session_key]['user'])) {
			
			if ($_SESSION[self::session_key]['user'] instanceof User) {
				
				return $_SESSION[self::session_key]['user'];
				
			}
			
		}
	
	}
	
	public static function randomString($size) {
		
		$s = "";
		
		for ($i = 0; $i < $size; $i++) {
			
			$random = rand(0,61);
			
			if ($random < 10) 
				$s .= chr(ord("0") + $random);
			elseif ($random < 36) 
				$s .= chr(ord("A") + $random - 10);
			else 
				$s .= chr(ord("a")+ $random - 36);
			
		}
		
		return $s;
		
	}
	
	public static function createFromAuthSHA1(array $data) {
		
		$test = false;
		
		if (isSet($data["code"])) {
			
			$code = $data["code"];
			self::startSession();
			$gds = $_SESSION[self::session_key]['gds'];
			$pdo = myPDO::getInstance();
			
			$rq1 = $pdo->prepare(<<<SQL
			SELECT numEntrepreneur, prenom, nom, adresse, mail, fonction, 
			FROM user
			WHERE SHA1(concat(SHA1(login), ?, sha1pass)) = ?
SQL
);
			$rq1->execute(array($gds, $code));
			$rq1->setFetchMode(PDO::FETCH_CLASS, 'Entrepreneur');
			$test = $rq1->fetch(PDO::FETCH_CLASS);
			
		}
		
		if (!$test) {
			
			throw new AuthenticationException();
			
		} else {
			
			self::startSession();
			$_SESSION[self::session_key]['connected'] = true;
			
		}
		
		return $test;
		
	}
	

}
