<?php
//Si on travaille en utf-8 (recommandé)
header('Content-type: text/html; charset=UTF-8');

// Appel de la classe
require('../Classe_Upload.php');
 
require('../adresses_dossiers.php');


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

?>
<!doctype html>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Téléchargement de fichiers, upload multiple avec complément fonctions javascript</title>

<script type="text/JavaScript">
<!--
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
-->
</script>
<style type="text/css">
body {
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
}
 
p, input, form {
margin:0;
padding:0;
}
 
#bord_form {
width:700px;
margin:auto;
border:5px  double #999999;
padding-top:1em;
padding-bottom:1em;
}
 
#content_form {
width:650px;
margin:auto;
font-size:0.8em;
}
 
.info p {
margin-top:0.3em;
}
 
#form_file {
text-align:right;
}
 
#form_file p {
margin-top:1.5em;
}
 
#form_file #champ_file input {
margin-top:0.3em;
padding:0;
height:1.8em;
width:100%;
}
 
#form_file #add_load_file {
font-size:0.85em;
text-decoration:underline; 
cursor:pointer;
}
 
#form_file #envoyer {
width:8em;
height:2.5em;
font-weight:bold;
}
 
#message_tele {
margin-top:1em;
}
</style>
 
 
</head>
 
<body>
 
<div id = "bord_form">
 
	<div id = "content_form">
 
		<div class = "info">
		<p>Fichiers autorisés "jpg", "jpeg", "gif", "png".</p>
 
		<p>Taille maximum de fichier autorisée par le serveur = <?php echo $max_fichier_serveur.'o'?>.&nbsp;&nbsp;Total maximum pour l'ensemble <?php echo $max_post_serveur.'o'?>.</p>
		</div>
 
		<form id = "form_file" enctype = "multipart/form-data" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?get_form=1'?>" method = "post" onsubmit = "Attente_Load('message_tele')">
 
		<p id = "champ_file"><input type = "file" name = "photo[]"  multiple = "multiple" /></p>
 
		<p id = "add_load_file" onclick = "Add_Load_File('champ_file')">Ajouter un champ de téléchargement</p>
 
		<p><input type = "submit" name = "envoi_file" value = "Envoyez" id = "envoyer" /></p>
 
		</form>
 
		<div id = "message_tele" class = "info">
 
		<?php if (isset($messages_form))
        foreach ($messages_form as $num)
		{
			foreach ($num as $value)
			echo '<p>- '.htmlspecialchars($value).'</p>';
		}
        ?>
		</div>
 
	</div>
     
</div>

<div style="margin-top:50px">
La classe d'upload est compatible avec l'attribut html5 "multiple" qui permet de sélectionner plusieurs fichiers simultanément en maintenant la touche "Ctrl" enfoncée durant la sélection des fichiers.
<br><br>

Le paramétrage de la classe est inchangé, tout se situe dans le code html où il suffit d'ajouter l'attribut multiple = "multiple" dans le champ de type file sans oublier de déclarer son nom sous forme d'un tableau (ici name = "photo[]").
<br><br>

Cependant cet attribut "multiple" n'est pas supporté par tous les navigateurs récents. De plus il ne permet que la sélection multiple de fichiers provenant d'un même répertoire. Une solution "universelle" est donc de proposer l'ajout supplémentaire de champs possédant l'attribut multiple avec une fonction javascript complémentaire.
</div>

</body>