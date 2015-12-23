<?php

include_once "utilisateur.class.php";
include_once "myPDO.include.php";
include_once "entreprise.class.php";

class AuthenticationException extends Exception { }

class wrongEntryException extends Exception { }

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

		    $entrepreneur->entreprises[] = Entreprise::creatFromId($entrepreneur);
		    
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

	/**
	 * Mes à jour une entrepreprise observé par l'entrepreneur
	 * @param L'entreprise modifié
	 * @throws si le parametre n'est pas une entreprise
	 */
	public function notifyUpdate( $entreprise){
		if(is_object($entreprise) && $entreprise instanceof Entreprise){

			for($i =0; $i < sizeof($this->entreprises);$i++) {
				if($entreprise->getId() == $this->entreprises[$i]->getId()){
					$this->entreprises[$i] = $entreprise; 
				}
			}
		}
		else
			throw new wrongEntryException("Le paramentre n'est pas une instance 'Entreprise'. ");

	}


	/**
	 * Ajoute une entreprise observé par l'utilisateur
	 * @param L'entreprise rajouté
	 * @throws si le parametre n'est pas une entreprise
	 */
	public function notifyAjout( $entreprise){
		if(is_object($entreprise) && $entreprise instanceof Entreprise){
		    $this->entreprises[] = $entreprise;
		}
		else
			throw new wrongEntryException("Le paramentre n'est pas une instance 'Entreprise'. ");

	}

	//Getter sur la fonction
	public function getFonction(){
		return $this->fonction;
	}

	public function getEntreprises(){
		return $this->entreprises;
	}

	public function addEntreprise($entreprise){
		$this->entreprises[] = $entreprise;
	}
}


