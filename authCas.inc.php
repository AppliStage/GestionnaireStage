<?php
require_once "class/etudiant.class.php";
require_once "class/enseignant.class.php";
require_once "class/administrateur.class.php";
require_once "CAS-1.3.4/CAS.php";
require_once "config.php";

/* TO-DO : 
 * - Crée une gateway pour que les enseignant et les etudiants puissent ce log depuis le formulaure de l'application.
 */

// Enable debugging
phpCAS::setDebug();
// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, false);

// no SSL validation for the CAS server
phpCAS::setNoCasServerValidation();

// force CAS authentication
if(phpCAS::forceAuthentication()) {

	/* Si l'utilsiateur a 3 chiffre dans sont login, c'est un étudiant, sinon c'est un enseignant.
	 * Si c'est un ensignant on vérifi qu'il soit pas un administrateur.
	 */
	if(preg_match ( "/^[-a-z]{5}[0-9]{3}$/" , phpCAS::getUser() )){
		if( ($etudiant = Etudiant::createFromLogin(phpCAS::getUser())) != null){
			//$etudiant->saveIntoSession();
		}else {
			try{
				Etudiant::inscription(phpCAS::getUser());
				$etudiant = Etudiant::createFromLogin(phpCAS::getUser());
				//$etudiant->saveIntoSession();	
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}
	else if( ($admin = Administrateur::createFromLogin(phpCAS::getUser())) != null){
	   	$admin->saveIntoSession();
	}
	else {
		if (($enseignant = Enseignant::createFromLogin(phpCAS::getUser())) != null)
				$enseignant->saveIntoSession();
		else{
			try{
				Enseignant::inscription(phpCAS::getUser());
				$enseignant = Enseignant::createFromLogin(phpCAS::getUser());
				//$enseignant->saveIntoSession();	
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}

	}



}

