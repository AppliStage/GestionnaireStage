<?php 
//Si on travaille en utf-8 (recommandé)
header('Content-type: text/html; charset=UTF-8');

// Appel de la classe
require('../Classe_Upload.php');

require('../adresses_dossiers.php');

/* 
L'adresse des dossiers passés en paramètre à la fonction d'upload doit être fournie par rapport à la racine du serveur.

En utilisation courante, suivant que vous êtes sur un serveur distant ou sur un serveur d'évaluation, et en supoosant par exemple que le dossier 'PDF' soit situé à la racine du site, vous devriez indiquer :

$dossier_pdf = 'PDF';
ou
$dossier_pdf = 'dossier_du_site/PDF';

Dans ces exemples le chemin des dossiers est défini automatiquement avec "adresses_dossiers.php" pour les tests.
*/

$up = new Telechargement($dossier_pdf,'form1','doc');
 
$extensions = array('pdf','txt','doc','docx','odt','jpg','jpeg','png','gif');

$up->Set_Extensions_accepte ($extensions);

//$up->Set_Message_court('upload ok');

//$up->Set_Controle_fichier();

$up->Upload('reload');

$messages = $up->Get_Tab_message();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Exemple basique</title>
<style type="text/css">
body {font-family:Arial, Helvetica, sans-serif; font-size:12px;}
</style>
</head>
<body>

<form enctype = "multipart/form-data" action = "#" method = "post">	  
<input name = "doc" type = "file" />				 
<input type = "submit" name = "form1" value = "Envoyez"  />	
</form>

<div style="margin-top:30px">
<?php   
foreach ($messages as $num)
{
	foreach ($num as $value)
	echo htmlspecialchars($value).'<br />';
}
?>
</div>

<div style="margin-top:50px">
Dans le code ci-dessus vous pourriez ne pas utiliser $up->Get_Tab_message() qui affiche les messages d'erreur et de résultats. Cependant si un problème se produisait durant l'upload (mauvaise extension, fichier trop lourd) vous n'en connaîtrez pas la cause, le même que vous n'aurez pas de confirmation du résultat.<br>
<br> 

Il existe de nombreuses possibilités pour paramétrer le retour du tableau des messages obtenu par Get_Tab_message(). Notamment vous pourriez compléter ce code par l'utilisation de Set_Message_court() qui permet de retourner un message de votre choix passé en paramtètre à cette fonction, ou uniquement les messages d'erreurs si cette fonction est utilisée sans parmètre.<br>
<br>

En complément vous disposez aussi de deux autres fonctions Get_Tab_result() et Get_Tab_upload() pour récupérer un tableau de résultat plus détaillé permettant par exemple d'enregistrer le nom des fichiers en bdd (ainsi que leurs dimensions s'il s'agit d'images).<br>
<br>

Notez qu'il faudrait compléter la configuration de la classe avec Set_Renomme_fichier() ou Set_Controle_fichier() si vous souhaitez éviter l'écrasement de fichiers déjà existants sur le serveur.
</div>
</body>
</html>