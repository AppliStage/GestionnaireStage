<?php
include_once 'autoload.inc.php';
include_once 'init.inc.php';

if(isset($_REQUEST['id'])){

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


	//var_dump($stage->getEntreprise());
	$p->appendContent(<<<HTML
		<div class="container">
			<div class="jumbotron">
				<div class="page-header">
				  <h1>Stage <small>{$stage->getDomaine()} </small></h1>
				</div>
			</div>

			<h3><strong>{$titre} ({$nbPoste} poste(s))</strong></h3>
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
				{$dateDebut} à {$dateFin} 
			</p>
			<p>
				<strong>Rémunération</strong><br/>
				{$gratification}
			</p>
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
		    $(".nav-tabs a").click(function(){
		        $(this).tab('show');
		    });
		});
		</script>
Footer
	);
	echo $p->toHTML();
}


