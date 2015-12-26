<?php 
//Si on travaille en utf-8 (recommandé)
header('Content-type: text/html; charset=UTF-8');

// Appel de la classe
require('../Classe_Upload.php');

require('../adresses_dossiers.php');
 
 
//Liste des dossiers autorisés (sans caractères spéciaux ni accents, ni espaces). 

$dossiers_autorise = array('dossier photos' => $dossier_photo,'dossier pdf' => $dossier_pdf);
 
$dossier = $dossiers_autorise['dossier photos'];
$extensions = array("jpeg", "jpg", "pdf");

$erreur_dossier = null;
 
// Si le formulaire est envoyé on regarde si $_POST['categorie'] fait partie du tableau de dossiers autorisés
if(isset($_POST['form_envoi'],$_POST['categorie']))
{
	if (in_array($_POST['categorie'],$dossiers_autorise))

	$dossier = $_POST['categorie'];

	else

	$erreur_dossier = 'Vous devez choisir le dossier';
}
 
 
if (empty($erreur_dossier))
{
	//Utilisation de la classe de téléchargement (cf la doc pour plus de précisions)
	 $up = new Telechargement($dossier,'form_envoi','fich_upload','get_form');

	//Extensions autorisées
	$up->Set_Extensions_accepte ($extensions);

	// En cas de doublon sur le serveur, les fichiers seront renommés  avec une méthode incrémentale.
	$up->Set_Renomme_fichier('incr');

	// Envoi des données et traitement de l'upload avec rechargement de la page pour éviter un multi upload en cas de rafraichissement de la page.
	$up->Upload('reload');

	// Récupération des messages d'information
	$resultat = $up->Get_Tab_message();
}
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Dossier de destination défini dans le formulaire</title>
<style type="text/css">
body {font-family:Arial, Helvetica, sans-serif; font-size:12px;}
</style>

</head>
 
<body>
<div>
Extensions autorisées <?= implode(', ',$extensions)?>
 
<form enctype = "multipart/form-data" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?get_form=1'?>" method = "post">  
<p>  
Dossier : <select name="categorie" >
<option value="">Choisissez...</option>
<?php foreach ($dossiers_autorise as $libelle => $value) echo '<option value="'.$value.'">'.$libelle.'</option>';?>
 
</select>
 
<br /> <br />
 
<input name = "fich_upload[]" type = "file" size = "70" />
 
<input type = "submit" name = "form_envoi" value = "Envoyez"  />  
</p>  
</form>
    <div style="margin-top:20px;">
 
        <?php if (!empty($resultat))
 
        foreach ($resultat as $num)
		{
			foreach ($num as $value)
			 echo htmlspecialchars($value).'<br />';
		}
 
        if(isset($erreur_dossier)) echo $erreur_dossier;
 
        ?>
    </div>
</div>

<div style="margin-top:50px">
Il s'agit dans cet exemple d'utiliser une variable post pour initialiser la classe avec un dossier de destination choisi dans le formulaire.<br>
<br>

L'intérêt de ce code est qu'il permet d'instancier la classe ($up = new Telechargement($dossier,'form_envoi','fich_upload','get_form');) même en l'absence de variables $_POST (dans l'optique de pouvoir gérer l'erreur de dépassement post_max_size qui annule toutes les variables $_POST et $_FILES)<br><br>


Autre remarque de cet exemple, par défaut on indique un nom de dossier valide ($dossier = $dossiers_autorise['dossier photos'];) pour qu'au chargement de la page, en attente d'un dossier choisi, la classe trouve un nom de dossier valide et ne renvoie pas un message d'erreur de dossier de destination. 
</div>
</body>
</html>