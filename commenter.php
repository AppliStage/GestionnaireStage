<?php
require_once "autoload.inc.php";
require_once "init.inc.php";

if(isset($_REQUEST['contenu']) && isset($_REQUEST['id']) && $user instanceof Enseignant){
	try{
		$user->deposerCommentaire(new Commentaire($user->getNom." ".$user->getPrenom, $_REQUEST['contenu'], date("Y-m-d"));
		header("Location: displayEntreprise.php?id={$_REQUEST['id']}");
	    exit;
	}
	catch(Exception $e){
		header("Location: profileURCA.php?err=3");
	}
}