<?php
include_once 'autoload.inc.php';
include_once 'init.inc.php';
include_once "myPDO.include.php";

if($user instanceof Entrepreneur){

  if(isset($_REQUEST['id']) && isset($_REQUEST['loginEtudiant'])){
      if(isset($_REQUEST['accepte'])){
      
      }elseif(isset($_REQUEST['decline'])){
	    $pdo = myPDO::getInstance();
	    $req = $pdo->prepare(<<<SQL
	    	SELECT mail
	    	FROM Etudiant
	    	WHERE loginEtudiant = ?
SQL
		);
	    $req->execute(array($_REQUEST['loginEtudiant']));
	    $mail = $req->fetch();
		
	    require_once('class/mail/class.phpmailer.php');
	    
	    $email = new PHPMailer();
	    $email->Subject = "Proposition de stage";
	    $email->Body = "Votre offre a ete decline";
	    $email->addCC($mail['mail']);	    
	    $email->Send();
      }
   }
}


