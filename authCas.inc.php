<?php
include_once "class/etudiant.class.php";
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

	/* On cherche à savoir si l'utilisateur est un etudiant, puis si c'est un enseignant. 
	 * Si le login est introuvable c'est un etudiant qui se connect pour la première fois
	 * puisque les enseignants garant sont enregistrés par l'administrateur.
	 */
	if(($etudiant = Etudiant::createFromLogin(phpCAS::getUser())) != null){
		$etudiant->saveIntoSession();
	}
	/*if else(($enseignant = Enseignant::createFromLogin(phpCAS::getUser())) != null){

	}*/
	else{
		try{
			Etudiant::inscription(phpCAS::getUser());
			$etudiant = Etudiant::createFromLogin(phpCAS::getUser());
			$etudiant->saveIntoSession();	
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
}

