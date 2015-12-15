<?php

require_once("autoload.inc.php");
require_once("myPDO.include.php");

abstract class User {
	
	private $id;
	private $address;
	private $mail;
	private $ville;
	private $lastName;
	private $firstName;
	private $login;
	private $cp;
	const session_key = "__user__";
	
	private function __construct() {
		 
	}
	
	/**
	 * Méthode permettant de créer, si non faite, une session
	 */
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
	
	/**
	 * Méthode permettant de savoir si l'utilisateur est connecté
	 */
	public static function isConnected() {

		self::startSession();
		return isset($_SESSION[self::session_key]) && $_SESSION[self::session_key]['connected'];
		
	}
	
	/**
	 * Méthode permettant de détruire une session à condition que
	 * la donnée de formulaire logout soit rentrée
	 */
	public static function logoutIfRequested() {
		
		if (isSet($_POST['logout']) && self::isConnected()) {
			
			session_destroy();
			
		}
		
	}
	
	/**
	 * Méthode permettant de sauvegarder les données de l'utilisateur dans la session
	 */
	public function saveIntoSession() {
		
		$_SESSION[self::session_key]['user'] = $this;
		
	}
	
	/**
	 * Méthode permettant de récupérer l'objet User de la session actuelle à condition bien sur qu'il soit un objet de type User
	 */
	public static function createFromSession() {
		
		self::startSession();
		
		if (isSet($_SESSION[self::session_key]) && isSet($_SESSION[self::session_key]['user'])) {
			
			if ($_SESSION[self::session_key]['user'] instanceof User) {
				
				return $_SESSION[self::session_key]['user'];
				
			}
			
		}
	
	}
	
	/**
	 * Méthode générant une chaîne de caractères en utilisant ceux de 0 à 9, a à z et A à Z d'une certaine longueur passée en paramètre.
	 */ 
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
	
	/**
	 * Méthode permettant de récupérer l'utilisateur de manière sécurisée.
	 */
	public static abstract function createFromAuthSHA1(array $data);
	
}