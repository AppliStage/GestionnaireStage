<?php

Class NotInSessionException extends Exception{ }

abstract class Utilisateur{
	
	// Nom de l'utilisateur
	protected $nom;
	
	// Prenom de l'utilisateur
	protected $prenom;
	
	// Id de l'utilisateur
	protected $id;
	
	// Mail de l'utilisateur
	protected $mail;

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

   	/**
   	 * Vérifie si l'utilisateur est connecté.
   	 * @return true si il est connecté false sinon.
   	 */
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
        if (isset($_REQUEST['logout']) && self::isConnected()) {
            self::startSession() ;
            unset($_SESSION[self::session_key]) ;
        }
    }

    /**
     * Sauvegarde l'instance courrante de l'utilisateur dans les données de session.
     */
	public function saveIntoSession() {
		
		$_SESSION[self::session_key]['user'] = $this;
		
	}


	/**
	 * Génére un code aléatoire (grain de sel)
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
     * Production d'un formulaire de connexion contenant un challenge et une méthode JavaScript de hachage
     * @param string $action URL cible du formulaire
     * @param string $submitText texte du bouton d'envoi
     *
     * @return string code HTML du formulaire
     */
    static public function loginFormSHA1($action, $submitText = 'Sign in') {
        $texte_par_defaut = 'login' ;
        // Mise en place de la session
        self::startSession() ;
        // Mémorisation d'un challenge dans la session
        $_SESSION[self::session_key]['challenge'] = self::randomString(16) ;
        // Le formulaire avec le code JavaScript permettant le hachage SHA1
        // Le retour attendu par le serveur est SHA1(SHA1(pass)+challenge+SHA1(login))
        return <<<HTML
			<script type='text/javascript' src='js/sha1.js'></script>
			<script type='text/javascript'>
			function crypter(f, challenge) {
			    if (f.mail.value.length && f.pass.value.length) {
			    	if(f.mail.value.indexOf("@") == -1) 
			    		window.location.href = "profile.php";
			    	else{
				    	f.code.value = SHA1(SHA1(f.pass.value)+challenge+SHA1(f.mail.value)) ;
				        f.mail.value = f.pass.value = '' ;
				        return true ;
			    	}
			    }
			    return false ;
			}
			</script>

			<ul class="nav navbar-nav navbar-right">
				<li>
				  <form method="POST" action="{$action}" name="connexion" class="navbar-form navbar-left" onSubmit="return crypter(this, '{$_SESSION[self::session_key]['challenge']}')">
					<div class="form-group">
					  <label class="sr-only" for="mail">Email address</label>
					  <input type="text" class="form-control" name="mail" placeholder="Email ou login">
					</div>
					<div class="form-group">
					  <label class="sr-only" for="pass">Password</label>
					  <input type="password" class="form-control" name="pass" placeholder="Password">
					  <input type='hidden' name='code'>
					</div>
					<button type="submit" class="btn btn-default">{$submitText}</button>
					<a class="btn btn-primary" href="inscription.php" role="button">Sign up</a>
				  </form>
				</li>
	        </ul>
HTML;
    }



	/**
	 * Vérifie le contenu des attributs et enregistre l'utilisateur si
	 * il n'exite pas déjà.
	 * @return Renvoie true si l'utilisateur a pu s'inscrire, false sinon.
	 */
	//abstract function inscription($nom, $prenom, $mail, $pass =null, $tel = null,$adresse=null, $fonction=null);
	
	
	// Les getters de la foliiiiiiiie !!!!!

	public function getNom(){
		return $this->nom;
	}
	
	public function getPrenom(){
		return $this->prenom;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getMail(){
		return $this->mail;
	}
	
	public function getTel(){
		return $this->tel;
	}
	
} 

