<?php
require_once 'class/utilisateur.class.php';

//Varibale commune
$user = null;

if(!Utilisateur::isConnected()){
	include "authCas.inc.php";
}

try{
  $user = Utilisateur::createFromSession();
}catch(Exception $e){
	header("Location: authCas.inc.php");
	exit;
}



if (isset($_REQUEST['logout'])) { 

  if (isset($_SESSION['phpCAS'])){
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
    phpCAS::logoutWithRedirectService("http://localhost/www/GestionnaireStage/authentification-cas.php");
  }
  else{
    Utilisateur::logoutIfRequested();
    header("Location: authentification-cas.php");
    exit;
  }

}