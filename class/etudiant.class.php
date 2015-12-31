<?php

include_once "utilisateur.class.php";
include_once "myPDO.include.php";

class loginUtiliser extends Exception { }

class wrongTypeFile extends Exception { }

Class Etudiant extends Utilisateur{

   // Curriculum vitae
	private $cv;

   // Lettre de motivation
	private $lettre;

   // Listes des offres de stage auquel l'étudiant à postuler.
	private $offres;

     /**
     * Constructeur d'un etudiant en fonction de son login
     * @param login de l'étudiant
     * @return une instance d'étudiant sinon renvoi null
     */
	public static function createFromLogin($login){
		self::startSession();

		if( strlen($login) == 8){
			$pdo = myPDO::getInstance();
			$rq1 = $pdo->prepare(<<<SQL
				SELECT loginEtudiant AS 'id', prenom, nom, mail, tel
				FROM Etudiant
				WHERE loginEtudiant = ?
SQL
			);
			$rq1->execute(array($login)) ;

			$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    if (($etudiant = $rq1->fetch()) !== false) {
		    	$_SESSION[self::session_key]['connected'] = true;

		    	$etudiant->cv = null;
		    	$etudiant->lettre = null;
		    	$etudiant->offres = array(); //TO-DO :  Liste de stages
		        return $etudiant ;
		    }
		}
		return null;
	}

	/** 
	* Ajoute un stage à la listes des candidatures de l'étudiant et envoie le mail.
	* La BD est aussi mise à jour.
	* @param s stage à rajouter.
	* @throws si le parametre n'est pas un stage
	 */
	public function postulerStage($stage){
		if( is_object($stage) && $stage instanceof Stage){
			$this->offres[] = $stage;
			$pdo = myPDO::getInstance();
			//TO-DO : Erreur dans la base de donnée. Il manque une association dans la BD entre les stages et les etudiants
			$pdo->prepare(<<<SQL
			INSERT INTO postuler(numStage, loginEtudiant)
				values(?, ?)
SQL
			);
			$pdo->execute(array($stage->getId(), $this->id));		
		}
		else 
			throw new wrongTypeFile("Le paramentre n'est pas une stage.");
	}


	/**
	* Permet à un etudiant de s'inscrire dans la base de donnée, seul le login est obligatoire
	* @throws si le login est déja utilsé dans la base de donnée.
	*/
	public static function inscription( $login, $nom="", $prenom="", $mail="", $tel=""){
	    $pdo = myPDO::getInstance();
	    
	    $req = $pdo->prepare(<<<SQL
	    	SELECT 'a'
	    	FROM Etudiant
	    	WHERE loginEtudiant = ?
SQL
		);
	    $req->execute(array($login));

	    if($req->fetch() != false)
	    	throw new loginUtiliser("Ce compte exite déjà dans la base de donnée.") ;

		$req1 = $pdo->prepare(<<<SQL
			INSERT INTO Etudiant (loginEtudiant,prenom,nom,mail,tel)
			VALUES(?,?,?,?,?)
SQL
		);
		
		$ins = $req1->execute(array($login,$prenom,$nom,$mail,$tel));
	}


	/**
	 * Setter sur le CV
	 * @throws si le fichier n'est pas une fichier pdf
	 */
	public function setCV($cv){
		if (is_object($cv) && ($cv instanceof File)){
			$this->cv = $cv;
		}
		else
			throw new wrongTypeFile("Le fichier n'est pas un PDF.");
	}


	/**
	 * Setter sur la lettre de motivation
	 * @throws si le fichier n'est pas une fichier pdf
	 */
	public function setLetter($lettre){
		if (is_object($lettre) && $lettre instanceof File){
			$this->lettre = $lettre;
		}
		else
			throw new wrongTypeFile("Le fichier n'est pas un PDF.");
	}


}

