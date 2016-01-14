<?php
include_once "myPDO.include.php";
include_once "autoload.inc.php";
include_once "class/entreprise.class.php";
require_once "init.inc.php";

if (isset($_REQUEST['titre']) && isset($_REQUEST['description']) && isset($_REQUEST['gratification']) && isset($_REQUEST['domaine']) &&
 isset($_REQUEST['dateDebut']) && isset($_REQUEST['dateFin']) && isset($_REQUEST['nbPostes']) && isset($_REQUEST['id']) ){

 	$dateDebut = date("Y-m-d",strtotime($_REQUEST['dateDebut']));
	$dateFin = date("Y-m-d",strtotime($_REQUEST['dateFin']));

 	$entrepriseChoisi = null;
 	foreach ($user->getEntreprises() as $key => $entreprise) {
 		if($entreprise->getId() == $_REQUEST['id']){
 			$entrepriseChoisi = $entreprise;
 		}
 			
 	}


	if($_REQUEST['nbPostes'] >= 1 && 
		$dateFin != false &&
		$dateDebut != false &&
		$entreprise != null){

		$stage =  new Stage();

		$entreprise = $user->getEntreprises();

		$stage->setTitre($_REQUEST['titre']);
		$stage->setDescription($_REQUEST['description']);
		$stage->setGratification($_REQUEST['gratification']);
		$stage->setDateDebut($dateDebut);
		$stage->setDateFin($dateFin);
		$stage->setDomaine($_REQUEST['domaine']);
		$stage->setEntreprise($entrepriseChoisi);
		$stage->setNbPoste($_REQUEST['nbPostes']);

		$stage->save();

	    $pdo = myPDO::getInstance();
	    $req = $pdo->prepare(<<<SQL
	    	SELECT numStage
	    	FROM Stage
	    	ORDER BY dateCreation DESC LIMIT 1
SQL
		);
	    $req->execute();
	    
	    // mail
	    
		  // récupération des adresses
		  
		$reqAdresses = $pdo->prepare(<<<SQL
			SELECT mail
			FROM Etudiant
			WHERE 1
SQL
		);
		$reqAdresses->execute();
		$mails = $reqAdresses->fetchAll();
		
	    require_once('class/mail/class.phpmailer.php');
	    
	    $email = new PHPMailer();
	    $email->Subject = "Proposition de stage";
	    $email->Body = "plus tard...";
	    
	    foreach($mails as $mail) {
			
			if ($mail['mail'] != "") {
			
				$email->addCC($mail['mail']);
	    
			}
	    
	    }
	    
	    $email->Send();
	    
		header("Location: viewStage.php?id={$req->fetch()['numStage']}&stage=true");
		exit;
	}
	header("Location: entreprise.php?id={$_REQUEST['id']}&err=stage");
}