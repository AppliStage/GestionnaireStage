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

	//Gestion des réponse de l'enregistrement d'un entrepreneur
	if(isset($_GET['postuler'])){
		$toggleScript="$('#alert').show();";
		if($_GET['postuler']=="true") {
			$action="success";
			$contenu = "Votre candidature à été envoyé à {$entreprise->getNom()}.";
		}else{
			$action="danger";
			$contenu = "Vous ne pouvez pas postuler pour cette offre.";
		}
	}
	else{
		$toggleScript="";
		$action ="";
		$contenu ="";
	}

	$droit="";
	if(!$user instanceof Etudiant && $user->dejaConnu($_REQUEST['id']) ){
		$droit="disabled='disabled'";
	}


	//var_dump($stage->getEntreprise());
	$p->appendContent(<<<HTML
		<div class="container" style="margin-bottom:10%">

			<div class="row"> 
			    <div id="alert" class="alert alert-{$action} collapse" role="alert">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			        <strong>{$contenu}</strong>
			    </div>

				<div class="jumbotron">
					<div class="page-header">
					  <h1>Stage <small>{$stage->getDomaine()} </small></h1>
					</div>
				</div>

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
			<div class="page-header" style="text-align:center;margin-top:70px">
			</div>

			<form id = "form_file" enctype = "multipart/form-data" action = "postuler.php?id={$_REQUEST['id']}" method = "post" onsubmit = "Attente_Load('message_tele')">
				<div class="row">  <!-- Il ne peut y avoir qu'une seul class container par page -->
					<label for="titre">Sujet: </label>
					<input name="titre" type="text" class="form-control" placeholder="Tritre du stage" {$droit} required>

					<label for="contenu">Contenu du mail: </label>
					<textarea name="contenu" class="form-control" rows="10" placeholder="" {$droit}></textarea>

					<label for="photo[]">Ajouter des piéces jointes: </label>
					<input type = "file" name = "photo[]"  multiple = "multiple" />
					<div id = "champ_file"><input type = "file" name = "photo[]"  multiple = "multiple" /></div>
					<button type="button" id = "add_load_file" onclick = "Add_Load_File('champ_file')">+</button>
				</div>
				<div class="row" style="text-align:center;margin-top:8px"> 
					<button class="btn btn-lg btn-primary" id = "envoyer" name = "envoi_file" {$droit} type="submit">Postuler au stage</button>
				</div>
			</form>

		</div>
HTML
	);

/*

				<div id = "message_tele" class = "info">
					{$message}
				</div>
*/


$p->appendJS(<<<JS
	function Attente_Load(id_attente)// écrit patientez durant le téléchargement
	{              
		var id_attente = document.getElementById(id_attente);

		if (id_attente)
		{
			id_attente.innerHTML = 'Patientez...';  

			id_attente.style.fontWeight="bold";
			id_attente.style.fontSize="1.5em";         
		}
	}
	 
	 
	 
	function Add_Load_File(id_content_file) // Ajoute un champ de téléchargement
	{
		var content_file = document.getElementById(id_content_file);

		var tab = content_file ? content_file.getElementsByTagName('input') : new Array();

		if(tab.length > 0) 
		{
			var input = tab[0].cloneNode(true);
			input.value = '';
			content_file.appendChild(input);
		}	
	}
JS
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
			{$toggleScript}
		});
		</script>
Footer
	);

	echo $p->toHTML();
}


