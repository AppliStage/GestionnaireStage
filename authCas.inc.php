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
	// TO-DO création d'un etudiant ou d'un enseignant en fonction du login
	// ....
}

if (isset($_REQUEST['logout'])) {	
	phpCAS::logout();
	Utilisateur::logoutIfRequested();
}



