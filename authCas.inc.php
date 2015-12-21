<?php

require_once "CAS-1.3.4/CAS.php";
require_once "config.php";

// Enable debugging
phpCAS::setDebug();
// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, false);


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
		Etudiant::inscription($login);
	}
}

if (isset($_REQUEST['logout'])) {	
	phpCAS::logout();
	Utilisateur::logoutIfRequested();
}



