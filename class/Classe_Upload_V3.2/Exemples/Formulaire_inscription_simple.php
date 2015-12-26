<?php 
//Si on travaille en utf-8 (recommandé)
header('Content-type: text/html; charset=UTF-8');

// Appel de la classe
require('../Classe_Upload.php');
 
require('../adresses_dossiers.php');

$up = new Telechargement($dossier_photo,'form1','photo');

/* paramétrage extensions autorisées */
$extensions = array('jpg','jpeg'); 
$up->Set_Extensions_accepte ($extensions);

/* redimensionnement (si nécessaire) en maximum 100x100 */
$up->Set_Redim ('200','200');

/* message simplifié en retour pour le visiteur (par exemple) */
$up->Set_Message_court(': téléchargement effectué');

/* Condition $_POST d'envoi du formulaire */
if (isset($_POST['form1']))
{
	$pseudo = trim($_POST['pseudo']);
	if ($pseudo != '') /* il faudrait compléter le contrôle... */
	{
		/* Upload du fichier */ 
		$up->Upload();
	
		/* Récupération du tableau des résultats d'upload */
		$tab_result = $up->Get_Tab_upload();
		
		/* Si un seul champ unique de type file on peut récupérer le nom du fichier ainsi : */
		$nom_fichier = isset($tab_result['resultat'][0][$dossier_photo]['nom']) ? $tab_result['resultat'][0][$dossier_photo]['nom'] : 'avatar_par_defaut.jpg';

		/* Enregistrement du nom du fichier et du pseudo en bdd... */
		/* ... */
		$_SESSION['enregistrement'] = 'Pseudo "'.$pseudo.'" et avatar "'.$nom_fichier.'" enregistrés';
	} 
	else 
	{
		$_SESSION['enregistrement'] = 'Le pseudo doit être renseigné';
	}
	/* Pour éviter un message du navigateur en cas de rafraichissement de la page */
	$up->Get_Reload_page();
}

$message_enregistrement_html = isset($_SESSION['enregistrement'])?  $_SESSION['enregistrement'] : null;
unset($_SESSION['enregistrement']);

$messages_upload = $up->Get_Tab_message();
$messages_upload_html = null; 
foreach ($messages_upload as $num) foreach ($num as $value) $messages_upload_html .= '<p>- '.htmlspecialchars($value).'</p>';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>inscription, upload</title>
<style type="text/css">
body {font-family:Arial, Helvetica, sans-serif; font-size:12px;}
</style>

</head>
<body> 
Extensions autorisées <?= implode(', ',$extensions)?>
<form enctype = "multipart/form-data" action = "#" method = "post">	  
<p><label for="image">Image </label><input name="photo" id="image" type="file" /></p>
<p><label for="pseudo">pseudo *</label><input name="pseudo" id="pseudo" type="text" value="" /></p>
<p><input type="submit" name="form1" value="Envoyez" /></p>
</form>
<?= $messages_upload_html; ?>
<?= $message_enregistrement_html; ?>
<div style="margin-top:50px">
Un formulaire qui inclus un champ de type text : name='pseudo'  et un champ de type file : name= 'photo' pour rentrer l'avatar. En partant du principe que le nom du pseudo doit être obligatoirement renseigné pour permettre l'enregistrement d'un fichier téléchargé. Si pas de fichier on met un avatar par défaut.<br><br>

L'initialisation de la classe et la récupération des messages visiteurs étant exclus de toute condition $_POST, la classe pourra gérer l'erreur serveur de dépassement «post_max_size». <br><br>


Si besoin, on aurait pu mettre les fonctions de configuration  «Set_Extensions_accepte», «Set_Redim» et  «Set_Message_court» à l'intérieur de la condition «if (isset($_POST['form1']))». Cela dit, mettre les fonctions de configuration indépendamment d'une condition post permet de faire afficher les messages d'erreur de configuration (pour les fonctions qui en retournent) sans avoir à faire un test d'upload.<br><br>


Notes : <br>

- J'enregistre dans $_SESSION['enregistrement'] les messages de résultat de l'enregistrement du formulaire pour pouvoir les afficher après reload de la page.<br><br>

- Remarquez que si un problème survient durant le téléchargement d'une photo (erreur d'extension, fichier trop lourd etc.), le pseudo sera enregistré avec l'avatar par défaut, tout comme si l'utilisateur n'avait pas fourni de photo. On pourrait conditionner l'enregistrement du pseudo à l'absence de problème lors de l'upload dans le cas où une photo est proposée en téléchargement, et si erreur d'upload, différer l'enregistrement du pseudo et afficher le message d'erreur correspondant. Pour ce faire consulter l'exemple "Formulaire_inscription_complet_affichage_vignette.php" qui permet également l'affichage de la photo téléchargée.


</div>
</body>
</html>