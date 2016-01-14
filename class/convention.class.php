<?php
require_once "autoload.inc.php";

class Convention {
	
   private $numConvention;   
   private $valide;   
   private $loginEnseignant;   
   private $numStage;   
   private $loginEtudiant;   
   
   /**
    * Constructeur d'un Convention
    */
   
   public function __construct() {
	   
   }
   
    /**
     * Constructeur d'une Convention en fonction de son login
     * @param login de Convention
     * @return une instance de Convention sinon renvoi null
     */
	public static function createFromAdmin($numAdmin){
		if( strlen($numAdmin) == 8){
			$pdo = myPDO::getInstance();
			$rq1 = $pdo->prepare(<<<SQL
				SELECT numConvention ,valide, loginEnseignant, numStage, loginEtudiant
				FROM Convention
				WHERE numAdmin = ?
SQL
			);
			$rq1->execute(array($numAdmin)) ;

			$rq1->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		    return $rq1->fetchAll();
		}
	}
	
}