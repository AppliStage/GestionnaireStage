<?php

include_once "utilisateur.class.php";
include_once "myPDO.include.php";

class AuthenticationException extends Exception { }

class MailUtiliser extends Exception { }

class Entrepreneur extends Utilisateur {
   
   // Liste des entreprises géré par l'entrepreneur
   private $entreprises;
   private $fonction;
   const session_key = "__user__";

 
     /* Constructeur d'un entrepreneur
     
    public function __construct($nom, $prenom, $mail, $adresse, $tel, $fonction) {
	    	
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->mail = $mail;
		$this->adresse = $adresse;
		$this->tel = $tel;
		$this->fonction = $fonction;
		$_entreprises = array();
		
    }
    */
	
	public static function logoutIfRequested() {
		
		if (isSet($_POST['logout']) && self::isConnected()) {
			session_destroy();
		}
		
	}
	
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
	 *	Crée une instance d'entrepreneur a partir du code sha1(pass + grainDeSel + mail) envoyé par un formulaire
	 *  @param $data : Contien le code et le grain de sel (challenge)
	 *  @throws Exception si le code n'a pas été envoyé
	 *  @throws Exception si l'utilisateur n'existe pas dans la base de donnée
	 */
	public static function createFromAuthSHA1(array $data) {	
		if (!isset($data['code'])) {
          	throw new AuthenticationException("pas de login/pass fournis") ;
        }

		self::startSession();

		$pdo = myPDO::getInstance();
		$rq1 = $pdo->prepare(<<<SQL
		SELECT numEntrepreneur, prenom, nom, adresse, mail, fonction, tel
		FROM Entrepreneur
		WHERE SHA1(concat(pass, :challenge, SHA1(mail) )  ) = :code
SQL
);
		$rq1->execute(array(
        ':challenge' => isset($_SESSION[self::session_key]['challenge']) ? $_SESSION[self::session_key]['challenge'] : '',
        ':code'      => $data['code'])) ;

        // oublie le grain de sel rapidement pour qu'il puisse plu être retrouvé
        unset($_SESSION[self::session_key]['challenge']) ;

		$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
	    if (($entrepreneur = $rq1->fetch()) !== false) {
	    	$_SESSION[self::session_key]['connected'] = true;

	    	$entrepreneur->entreprises = array();		
	    	$entrepreneur->fonction = "";
	        return $entrepreneur ;
	    }
	    else {
	        throw new AuthenticationException("Login/pass incorrect") ;
	    }	
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
			        f.code.value = SHA1(SHA1(f.pass.value)+challenge+SHA1(f.mail.value)) ;
			        f.mail.value = f.pass.value = '' ;
			        return true ;
			    }
			    return false ;
			}
			</script>

			<ul class="nav navbar-nav navbar-right">
				<li>
				  <form method="POST" action="{$action}" name="connexion" class="form-inline" onSubmit="return crypter(this, '{$_SESSION[self::session_key]['challenge']}')" style="padding-top:8px">
					<div class="form-group">
					  <label class="sr-only" for="mail">Email address</label>
					  <input type="email" class="form-control" name="mail" placeholder="Email">
					</div>
					<div class="form-group">
					  <label class="sr-only" for="pass">Password</label>
					  <input type="password" class="form-control" name="pass" placeholder="Password">
					  <input type='hidden' name='code'>
					</div>
					<button type="submit" class="btn btn-default">{$submitText}</button>
					<a class="btn btn-default" href="inscription.php" role="button">Sign up</a>
				  </form>
				</li>
	        </ul>
HTML;
    }




	/**
	* Permet à un entrepreneur de s'inscrire dans la base de donnée
	* @return true si l'inscription c'est faite correctement, false sinon.
	* @throws si l'adresse mail est déja utilsé dans la base de donnée.
	*/
	public static function inscription($nom, $prenom, $mail, $pass, $tel = null,$adresse="", $fonction=""){
	    $pdo = myPDO::getInstance();

	    $req = $pdo->prepare(<<<SQL
	    	SELECT 'a'
	    	FROM Entrepreneur
	    	WHERE mail = ?
SQL
		);
	    $req->execute(array($mail));

	    if($req->fetch() != false)
	    	throw new MailUtiliser("Cette adresse mail est déja utilisé.") ;

		$req1 = $pdo->prepare(<<<SQL
			INSERT INTO Entrepreneur (numEntrepreneur,prenom,nom,adresse,mail,fonction,pass,tel)
			VALUES('',?,?,?,?,?,?,?)
SQL
		);
						
		$ins = $req1->execute(array($prenom,$nom,$adresse,$mail,$fonction,sha1($pass),$tel));
	}
	

}
