<?php
require_once "autoload.inc.php";
include_once "init.inc.php";

	if(isset($_POST['maj']) and isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['mail']) and isset($_POST['tel'])){
		
		$nomM = htmlspecialchars($_POST['nom']);
		$prenomM = htmlspecialchars($_POST['prenom']);
   		$mailM = htmlspecialchars($_POST['mail']);
		$telM = htmlspecialchars($_POST['tel']);
		$user->update($user->getId(),$nomM,$prenomM,$mailM,$telM);
		header("Location: profileURCA.php");
		exit;
	}
	else{
		header("Location: profileURCA.php?err=compteImcomplet");	
	}
	