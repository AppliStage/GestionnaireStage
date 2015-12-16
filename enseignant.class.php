<?php

require_once("autoload.inc.php");
require_once("myPDO.include.php");

class Enseignant extends User {

  public static function createFromAuthSHA1(array $data) {
		
		$test = false;
		
		if (isSet($data["code"])) {
			
			$code = $data["code"];
			self::startSession();
			$gds = $_SESSION[self::session_key]['gds'];
			$pdo = myPDO::getInstance();
			
			$rq1 = $pdo->prepare(<<<SQL
			SELECT N_PERSONNE, ADRPERS, MAILPERS, VILLEPERS, NOMPERS, PNOMPERS, IDENTIFIANT, CPPERS
			FROM PERSONNE
			WHERE SHA1(concat(SHA1(IDENTIFIANT), ?, PASSWORD)) = ?
SQL
);
			$rq1->execute(array($gds, $code));
			$rq1->setFetchMode(PDO::FETCH_CLASS, 'Enseignant');
			$test = $rq1->fetch(PDO::FETCH_CLASS);
			
		}
		
		if (!$test) {
			
			throw new AuthenticationException();
			
		} else {
			
			self::startSession();
			$_SESSION[self::session_key]['connected'] = true;
			
		}
		
		return $test;
		
	}

}