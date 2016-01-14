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
	echo $e->getMessage();
	exit;
}



if (isset($_REQUEST['logout'])) { 

  if (isset($_SESSION['phpCAS'])){
    require_once "CAS-1.3.4/CAS.php";
    require_once "config.php";

    // Enable debugging
    phpCAS::setDebug();
    // Initialize phpCAS
    phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, false);

    // no SSL validation for the CAS server
    phpCAS::setNoCasServerValidation();
    phpCAS::logoutWithRedirectService("http://pecca001/GestionnaireStage/index.php");
  }
  else{
    Utilisateur::logoutIfRequested();
    header("Location: index.php");
    exit;
  }

}