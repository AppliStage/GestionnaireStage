<?php

include_once "utilisateur.class.php";
include_once "myPDO.include.php";
include_once "entreprise.class.php";

class AuthenticationException extends Exception { }

class MailUtiliser extends Exception { }

class Entrepreneur extends Utilisateur {
   
   // Liste des entreprises géré par l'entrepreneur
   private $entreprises = array();
   private $fonction;
   const session_key = "__user__";

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
		SELECT numEntrepreneur AS 'id', prenom, nom, mail, fonction, tel
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

		    $req = $pdo->prepare(<<<SQL
		    	SELECT *
		    	FROM Entreprise
		    	WHERE numEntrepreneur = ?
SQL
			);
		    $req->execute(array($entrepreneur->id));
		    $entrepreneur->entreprises[] = $req->fetchAll(PDO::FETCH_CLASS, "Entreprise");

	        return $entrepreneur ;
	    }
	    else {
	        throw new AuthenticationException("Login/pass incorrect") ;
	    }	
	}

	/**
	* Permet à un entrepreneur de s'inscrire dans la base de donnée
	* @throws si l'adresse mail est déja utilsé dans la base de donnée.
	*/
	public static function inscription($nom, $prenom, $mail, $pass, $tel = null, $fonction=""){
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
			INSERT INTO Entrepreneur (numEntrepreneur,prenom,nom,mail,fonction,pass,tel)
			VALUES('',?,?,?,?,?,?)
SQL
		);
						
		$ins = $req1->execute(array($prenom,$nom,$mail,$fonction,sha1($pass),$tel));
	}



	//Getter sur la fonction
	public function getFonction(){
		return $this->fonction;
	}

	public function getEntreprises(){
		return $this->entreprises;
	}
}


