<?php

require_once "myPDO.include.php";

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
	
	function inscription($nom, $prenom, $adresse=null, $mail, $pass =null, $tel = null, $fonction=null){
	       				$pdo = myPDO::getInstance();
	       				$res = false;
	       				if(preg_match('[a-zA-Z]*',$nom) and preg_match('[a-zA-Z]*',$prenom) and preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',$nom) and preg_match('/^0[1-9]|[1-8][0-9]|9[0-8]|2A|2B$/', $tel)){
					  $pdo->prepare(<<<SQL
						      INSERT INTO Entrepreneur (numEntrepreneur,prenom,nom,adresse,mail,fonction,pass,tel)
						      VALUES('',?,?,?,?,?,?)
SQL
);
					$res = $pdo->execute(array($prenom,$nom,$adresse,$mail,$fonction,sha1($pass),$tel));
					}
					return $res;
	       				
	       				}
	

}
