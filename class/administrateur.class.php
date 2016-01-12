<?php
include_once "enseignant.class.php";

class Administrateur extends Utilisateur {
   
	private $_convention;
	private $enseignant;

    
    public  function __construct() {
		
	}
	
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
		    if (($admin = $rq1->fetch()) !== false) {
		    	$_SESSION[self::session_key]['connected'] = true;

		    	//$admin->convention  | crée une list de convention avec la class convention
		    	//$admin->enseignant  | Recupérer tous les ensignant en crée une methode Enseignant::getAll() dans la class enseignant
		        return $admin ;
		    }
		}
		return null;
	}
	
  
	public function valideAffectation( $num) {
		  
		$pdo = myPDO::getInstance();
			$rq1 = $pdo->prepare(<<<SQL
				SELECT loginEnseignant AS 'enseignant'
				FROM Convention
				WHERE numConvention = ?
SQL
			);
			$rq1->execute(array($num)) ;
			
		$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    if (($$rq1 = $rq1->fetch()) !== false) {
		    	
			$rq2 = $pdo->prepare(<<<SQL	
				UPDATE Convention SET valide=1 WHERE id=?
			SQL
			);
			
			$rq2->execute(array($rq1));
			
			}
		  
	}
	
	public function imprimer( $stage) {
		  
		
		  
	}
}