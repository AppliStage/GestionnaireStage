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
		<div name="divPostulation" class="container">
			<form class="form-horizontal" name="formPostulation" action="postuler.php" method="POST"> 
				<fieldset>
					<legend>Postulation</legend>
					<textarea class="form-control" style="height: 200px; width: 300px;" name="email"> </textarea>
HTML
	);
	
	// Module d'upload -----------------------------------------------------------------------------------------------------------------------------------
	
	require('class/upload/Classe_Upload.php');
	require('class/upload/adresses_dossiers.php');
	
	// Déclaration de la classe avec envoi des paramètres (cf doc)
	$form = new Telechargement ($dossier_photo,'envoi_file','photo','get_form');
	 
	// option : contrôle que le fichier est une image de type gif, jpg, jpeg ou png (et retourne ses dimensions dans le tableau des résultats - tableau non exploité dans l'exemple ci-dessous)
	$form->Set_Controle_dimImg ();
	 
	//option pour renommer le fichier en mode incrémentiel si un fichier de même nom existe déjà sur le serveur
	$form->Set_Renomme_fichier ('incr');
	 
	 
	//Téléchargement sans traitement php supplémentaire -> on spécifie un rechargement de la page suite au téléchargement en indiquant un argument non nul ex 'reload' dans la fonction d'Upload.
	$form->Upload ('reload');
	 
	 
	// Enregistrement des messages de contrôle
	$messages_form = $form->Get_Tab_message ();
	 
	 
	$config_serveur = $form->Return_Config_serveur('tableau');
	$max_fichier_serveur = $config_serveur['upload_max_filesize'];
	$max_post_serveur = $config_serveur['post_max_size'];
	
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
	
	$p->appendContent(<<<HTML
	<p id = "champ_file"><input type = "file" name = "photo[]"  multiple = "multiple" /></p>
	<button type="button" id = "add_load_file" onclick = "Add_Load_File('champ_file')">ajouter</button>
HTML
	);
	
	//----------------------------------------------------------------------------------------------------------------------------------------------------

	$p->appendContent(<<<HTML
					<button class="btn btn-lg btn-primary" type="submit">Postuler</button>
				</fieldset>
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
		    $(".nav-tabs a").click(function(){
		        $(this).tab('show');
		    });
		});
		</script>
Footer
	);
	echo $p->toHTML();
}


