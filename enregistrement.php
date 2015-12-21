<?php
include_once 'class/entrepreneur.class.php';

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['pass']) &&isset($_POST['tel'])){

	if(preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $_POST['mail'] ) &&
	preg_match ( "/^[a-zA-Z0-9_]{8,64}$/ " , $_POST['pass'] ) &&
	$_POST['nom'] != "" &&
	$_POST['prenom'] != ""){
		$nom = htmlspecialchars( $_POST['nom'] );
		$prenom = htmlspecialchars( $_POST['prenom'] );
		$mail = htmlspecialchars( $_POST['mail'] );
		$tel = htmlspecialchars( $_POST['tel'] );

		try{
			Entrepreneur::inscription($nom, $prenom, $mail, $_POST['pass'],$tel);
		}catch(Exception $e){
			//echo $e->getMessage();
			header("Location: inscription.php?ins=false");
			exit;
		}
		header("Location: inscription.php?ins=true");
	}
	else 
		header("Location: inscription.php");

}
