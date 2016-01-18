<?php
include_once 'autoload.inc.php';
include_once 'init.inc.php';
include_once "myPDO.include.php";

if($user instanceof Entrepreneur){

if(isset($_REQUEST['id']) && isset($_REQUEST['loginEtudiant'])){

	$p = new webpage("Iut Stage");
	$p->appendToHead(<<<head
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <meta name="description" content="">
	    <meta name="author" content="">
head
	);
	$p->appendCssUrl("style/bootstrap-3.3.5-dist/css/bootstrap.min.css");
	//inclusion de la barre de navigation
	include_once "navbar.inc.php";

	$stage = Stage::creatFromId($_REQUEST['id']);
	$entreprise = Entreprise::creatFromId($stage->getEntreprise());

	$titre = htmlspecialchars ($stage->getTitre());
	$nbPoste = htmlspecialchars ($stage->getNbPoste());
	$dateCreation = htmlspecialchars ($stage->getDateCreation());
	$ref = htmlspecialchars ($stage->getId());
	$nom = htmlspecialchars ($entreprise->getNom());
	$adresse = htmlspecialchars ($entreprise->getAdresse());
	$tel = htmlspecialchars ($entreprise->getTel());
	$description = nl2br(htmlspecialchars ($stage->getDescription()));
	$codePostal  =htmlspecialchars ($entreprise->getCodePostal());
	$adresse = htmlspecialchars ($entreprise->getAdresse());
	$ville = htmlspecialchars ($entreprise->getVille());
	$dateFin  = htmlspecialchars ($stage->getDateFin());
	$dateDebut = htmlspecialchars ($stage->getDateDebut());
	$gratification = htmlspecialchars ($stage->getGratification());
	
	//Etudiant
	$pdo = myPDO::getInstance();
	$rq1 = $pdo->prepare(<<<SQL
				SELECT loginEtudiant AS 'id', prenom, nom, mail, tel
				FROM Etudiant
				WHERE loginEtudiant = ?
SQL
			);
	$rq1->execute(array($_REQUEST['loginEtudiant'])) ;
	$rq1->setFetchMode(PDO::FETCH_CLASS, "Etudiant");
	$etudiant = $rq1->fetch();
	
	$nomEtudiant = htmlspecialchars($etudiant->getNom());
	$prenomEtudiant = htmlspecialchars($etudiant->getPrenom());
	$mailEtudiant = htmlspecialchars($etudiant->getMail());
	$telEtudiant = htmlspecialchars($etudiant->getTel());
	
	$p->appendContent(<<<HTML
		<div class="container" style="margin-bottom:10%">
		
		<div class="tab-pane fade in active" id="profile">
		  <div class="panel panel-default">
		     <div class="panel-heading">
			<h3 class="panel-title"><strong>Postulant : {$nomEtudiant} {$prenomEtudiant}</strong></h3>
                     </div>
                     <div class="panel-body">
			<strong>Nom : </strong>{$nomEtudiant}<br>
			<strong>Prénom : </strong>{$prenomEtudiant}<br>
                        <strong>Adresse mail : </strong>{$mailEtudiant}<br>
                        <strong>Téléphone : </strong>{$telEtudiant}
                     </div>
                    </div>
			<div class="row"> 

				<h3><strong style="color:#d9534f">{$titre} ({$nbPoste} poste(s))</strong></h3>
				<p>
					<stong>Employeur : {$nom} (<a href="{$entreprise->getSite()}">Site de l'entreprise</a>)</stong><br/>
					<strong>{$nbPoste} poste(s) | {$dateCreation} | Réf.{$ref}</strong>
				</p>
				<address>
				  <strong>Info général</strong><br>
				  {$adresse}<br>
				  {$ville}, {$codePostal}<br>
				  <abbr title="Téléphone">P:</abbr> {$tel}
				</address>

				<p>
					<strong>Description</strong><br/>
					{$description}
				</p>
				<p>
					<strong>Période</strong><br/>
					De {$dateDebut} à {$dateFin}.
				</p>
				<p>
					<strong>Rémunération</strong><br/>
					{$gratification}
				</p>
			</div>
			<form class="form-inline" action="actionCandidature.php?id={$_REQUEST['id']}&loginEtudiant={$_REQUEST['loginEtudiant']}" method="POST">
			     <div style="text-align:center;">
				      <button class="btn btn-lg btn-primary"  name = "accepte" type="submit">Accepter</button>
			     
				      <button class="btn btn-lg btn-danger"  name = "decline" type="submit">Décliner</button>
			    </div>
			 </form>
		</div>
HTML
	);



	$p->appendToFooter(<<<Footer
		<!-- Bootstrap core JavaScript
		 ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="style/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

		<script>
		$(document).ready(function(){
			//affiche le message d'alerte
			
		});
		</script>
Footer
	);

	echo $p->toHTML();
}
}


