<?php
require_once "class/enseignant.class.php";
require_once "autoload.inc.php";
require_once "init.inc.php";

if(isset($_REQUEST['contenu']) && isset($_REQUEST['id']) && $user instanceof Enseignant){
	try{
		$user->deposerCommentaire($_REQUEST['contenu'], $_REQUEST['id']);
		header("Location: displayEntreprise.php?id={$_REQUEST['id']}");
	    exit;
	}
	catch(Exception $e){
		echo $e->getMessage();
		//header("Location: profileURCA.php?err=3");
	}
}
var_dump($_REQUEST);
var_dump($user);


