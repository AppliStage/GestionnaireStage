<?php
include_once "enseignant.class.php";

class Administrateur extends Utilisateur {
   
	private $_convention;
	private $enseignant;

    
    public  function __construct() {
		$this->_convention = array();
	}
	
     /**
     * Constructeur d'un administrateur en fonction de son login
     * @param login de l'administrateur
     * @return une instance d'administrateur sinon renvoi null
     */
	public static function createFromLogin($login){
		self::startSession();

		if( strlen($login) == 8){
			$pdo = myPDO::getInstance();
			$rq1 = $pdo->prepare(<<<SQL
				SELECT numAdmin AS 'id'
				FROM Administrateur
				WHERE numAdmin = ?
SQL
			);
			$rq1->execute(array($login)) ;

			$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    if (($admin = $rq1->fetch()) !== false) {
		    	$_SESSION[self::session_key]['connected'] = true;

		    	//$admin->convention  | crée une list de convention avec la class convention
				$admin->_convention = Convention::createFromAdmin($admin->getId());
				
			   	//$admin->enseignant  | Recupérer tous les ensignant en crée une methode Enseignant::getAll() dans la class enseignant
				$admin->enseignant = Enseignant::getAll();
				
				$admin->saveIntoSession();
		        return $admin ;
			}
			else
				return null;
		}
		else
			throw new AuthenticationException("C'est pas un login  de l'URCA!");
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
		
		if (($rq1 = $rq1->fetch()) !== false) {
		    	
			    $sql = "UPDATE Convention SET valide=1 WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->execute($rq1);

    }

}