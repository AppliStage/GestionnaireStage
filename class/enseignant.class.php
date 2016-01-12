<?php



class Enseignant extends Utilisateur {
	
   private $_affectations;   
   public $_commentaire;
   
   /**
    * Constructeur d'un enseignant
    */
   
   public function __construct() {
	   
	 
	   $this->_affectations = array();
	   $this->_commentaire = array();
	   
   }
   
    /**
     * Constructeur d'un enseignant en fonction de son login
     * @param login de l'enseignant
     * @return une instance d'enseignant sinon renvoi null
     */
	public static function createFromLogin($login){
		self::startSession();

		if( strlen($login) == 8){
			$pdo = myPDO::getInstance();
			$rq1 = $pdo->prepare(<<<SQL
				SELECT loginEnseignant AS 'id', prenom, nom, mail, tel
				FROM Enseignant
				WHERE loginEnseignant = ?
SQL
			);
			$rq1->execute(array($login)) ;

			$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    if (($enseignant = $rq1->fetch()) !== false) {
		    	$_SESSION[self::session_key]['connected'] = true;

		    	$enseignant->_affectations = array();
			$enseignant->_commentaire = array();
			$enseignant->saveIntoSession();
		        return $enseignant;
		    }
		}
		return null;
	}
	
	/**
	* Permet à un etudiant de s'inscrire dans la base de donnée, seul le login est obligatoire
	* @throws si le login est déja utilsé dans la base de donnée.
	*/
	public static function inscription( $login, $nom="", $prenom="", $mail="", $tel=""){
	    $pdo = myPDO::getInstance();
	    
	    $req = $pdo->prepare(<<<SQL
	    	SELECT 'a'
	    	FROM Enseignant
	    	WHERE loginEnseignant = ?
SQL
		);
	    $req->execute(array($login));

	    if($req->fetch() != false){
		    	$req1 = $pdo->prepare(<<<SQL
			UPDATE Enseignant
			SET prenom = ?,nom = ?,mail= ?,tel= ?
			WHERE loginEnseignant = ?
SQL
		);
				$req1->execute(array($prenom,$nom,$mail,$tel,$login));
	    }else{
		$req1 = $pdo->prepare(<<<SQL
			INSERT INTO Enseignant (loginEnseignant,prenom,nom,mail,tel)
			VALUES(?,?,?,?,?)
SQL
				);
			$ins = $req1->execute(array($login,$prenom,$nom,$mail,$tel));
	    }	
	
	}

	public function update($login, $nom="", $prenom="", $mail="", $tel=""){
		self::inscription($login, $nom, $prenom, $mail, $tel);
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->mail = $mail;
		$this->tel = $tel;
	}
   
   /**
    * Ajoute un commentaire à la liste de commentaires.
    * @param Commentaire $e
    */
   public function deposerCommentaire($e) {
	if(strlen($this->nom)>1 and strlen($this->prenom)>1 and strlen($this->mail)>1 and strlen($this->tel)>1){
	  $this->_commentaire[] = $e;
	}else{
	  throw compteIncomplet("Votre profil n'est pas complet");
	}
   }
   
   /**
    * Ajoute un stage à la liste de stages.
    * @param Stage $stage
    */
   public static function affecterStage($stage) {
      if(strlen($this->nom)>1 and strlen($this->prenom)>1 and strlen($this->mail)>1 and strlen($this->tel)>1){
	  $this->_affectations[] = $stage;
      }else{
	  throw compteIncomplet("Votre profil n'est pas complet");
      }
   }

}