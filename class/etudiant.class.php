<?php

Class Etudiant extends Utilisateur{

   // Curriculum vitae
	private $_cv;

   // Lettre de motivation
	private $_lettre;

   // Listes des offres de stage auquel l'étudiant à postuler.
	private $_offres;

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
				WHERE login = :login
SQL
			);
			$rq1->execute(array(':login' => $login)) ;

			$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    if (($etudiant = $rq1->fetch()) !== false) {
		    	$_SESSION[self::session_key]['connected'] = true;

		    	$etudiant->_cv = null;
		    	$etudiant->_lettre = null;
		    	$etudiant->_offres = array(); //TO-DO :  Liste de stages
		        return $etudiant ;
		    }
		}
		return null;
	}

	/** 
	* Ajoute un stage à la listes des candidatures de l'étudiant.
	* La BD est aussi mise à jour.
	* @param s stage à rajouter.
	 */
	public function postulerStage($s){
		$pdo = myPDO::getInstance();
		$pdo->prepare(<<<SQL

SQL
	);
		$pdo->execute(array());
		return false;
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
	    	WHERE login = ?
SQL
		);
	    $req->execute(array($login));

	    if($req->fetch() != false)
	    	throw new MailUtiliser("Ce compte exite déjà.") ;

		$req1 = $pdo->prepare(<<<SQL
			INSERT INTO Etudiant (login,prenom,nom,mail,tel)
			VALUES(?,?,?,?,?,?,?)
SQL
		);
						
		$ins = $req1->execute(array($login,$prenom,$nom,$mail,$tel));
	}

}
