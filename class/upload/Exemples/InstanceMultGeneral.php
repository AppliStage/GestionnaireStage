<?php
//Si on travaille en utf-8 (recommandé)
header('Content-type: text/html; charset=UTF-8');

// Appel de la classe
require('../Classe_Upload.php');

require('../adresses_dossiers.php');
 
 
// Téléchargements de fichiers de nature différentes (photos et pdf) dans des répertoires différents avec si besoin renommage des fichiers, puis redimentionnement des images et traitement php.
$form_photo = new Telechargement($dossier_photo,'formulaire','photo','get_formulaire');
 
 
// Tableau des extensions autorisées (en minuscules). Dans cet exemple, seules les extensions "jpg" et "jpeg" sont autorisées
$extensions_photo = array('jpg','jpeg');
// Envoi du tableau des extensions autorisées
$form_photo->Set_Extensions_accepte($extensions_photo);
 
// Images originales téléchargées dans le répertoire "PHOTO" + mêmes images redimensionnées en max 950 x 800 téléchargées dans le répertoire "PHOTO_GF" + mêmes images redimensionnées en max 200 x 200 téléchargées dans le répertoire "PHOTO_PF"
 
$form_photo->Set_Redim ('950','800',$dossier_photo_GF);
$form_photo->Set_Redim ('200','200',$dossier_photo_PF);
 
// Contrôle de l'existence d'un fichier de nom identique dans le répertoire de destination et si oui renommage  du fichier téléchargé avec un suffixe unique.
$form_photo->Set_Renomme_fichier ();
 
 
// Téléchargement sans reload de la page
$form_photo->Upload ();
 
 
 
 
// Dans le même formulaire un fichier pdf à télécharger dans le répertoire "PDF"
$form_pdf = new Telechargement($dossier_pdf,'formulaire','pdf','get_formulaire');        
 
 
// Tableau des extensions autorisées (en minuscules). Dans cet exemple, seules les extensions "pdf" sont autorisées
$extensions_pdf = array('pdf');
// Envoi du tableau des extensions autorisées
$form_pdf->Set_Extensions_accepte ($extensions_pdf);
 
// Contrôle de l'existence d'un fichier de nom identique dans le répertoire de destination et si oui renommage du fichier téléchargé avec un suffixe incrémentiel
$form_pdf->Set_Renomme_fichier ('incr');
 
 
// Téléchargement sans reload de la page
$form_pdf->Upload ();
 
 
 
// Le reload de la page sera effectué à la fin du traitement php en utilisant la fonction "Get_Reload_page()"
if (isset($_POST['formulaire']))
{

	//Récupération des résultats
	//$transfert_form_photo = $form_photo->Get_Tab_upload ();
	//$transfert_form_pdf = $form_pdf->Get_Tab_upload ();

	// Voir la structure du tableau de résultat, et un exemple de récupération en fin de script


	//enregistrement des données en bdd etc.

	// Rechargement de la page pour éviter un multiple post en cas de rafraichissement de la page par le visiteur
	$form_photo->Get_Reload_page();
}
 
 
// A noter que l'appel à la fonction Get_Tab_message() doit se faire APRES la condition "if (isset($_POST..."
$messages_form_pdf = $form_pdf->Get_Tab_message ();
$messages_form_photo = $form_photo->Get_Tab_message ();
 
 
// Les deux lignes ci-dessous devraient logiquement se trouver à l'intérieur la condition "if (isset($_POST...)" pour servir par exemple à alimenter une bdd. Elles sont ici uniquement pour démonstration et afficher la structure du taleau de résultat en bas de page.
$transfert_form_photo = $form_photo->Get_Tab_upload ();
$transfert_form_pdf = $form_pdf->Get_Tab_upload ();


$config_serveur = $form_photo->Return_Config_serveur('tableau');
$max_fichier_serveur = $config_serveur['upload_max_filesize'];
$max_post_serveur = $config_serveur['post_max_size'];
 
/* Debug
 
- Si aucun message ne s'affiche après l'envoi d'un fichier, un ou plusieurs paramètres passés dans la déclaration de la classe sont erronés ou les variables de session ne fonctionnent pas sur votre serveur.
 
- Si le message "Le total maximum du post autorisé par le serveur est dépassé" s'affiche même pour un fichier de petite taille, le nom de l'input d'identification du formulaire passé en deuxième paramètre lors de l'initialisation de la classe est erroné.
 
*/
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Instanciation Multiple : plusieurs champs de type différents</title>
<script type="text/javascript">
<!--
function Verif_attente(id_attente)
{              
	var id_attente = document.getElementById(id_attente);
	
	if (id_attente)
	{
		id_attente.innerHTML = 'Patientez...';  
	
		id_attente.style.fontWeight="bold";
		id_attente.style.fontSize="1.5em";         
	}
}
-->
</script>
<style type="text/css">
body {
font-family: Arial, Helvetica, sans-serif;
font-size:12px;
}
 
p, input, form {
margin:0;
padding:0;
}
</style>
</head>
 
<body>
 
<div style="width:650px;margin:auto;">
 
    <form enctype = "multipart/form-data" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?get_formulaire=1'?>" method = "post" onsubmit = "Verif_attente('message_tele')">
    <p>
    <!-- input d'identification du formulaire qui doit être passé en paramètre dans l'initialisation de la classe-->
    <input type = "hidden" name = "formulaire" value = "1" />

    <label for="login">Login</label><br />
    <input type = "text" id = "login" name = "login"  /><br /><br />

    <span>Fichiers photos (<?= implode(', ',$extensions_photo)?>)</span><br />
    <input name = "photo[]" type = "file" /><br />
    <input name = "photo[]" type = "file" /><br /><br />

    <span>Fichier pdf (<?= implode(', ',$extensions_pdf)?>)</span><br />
    <input name = "pdf" type = "file" /><br /><br />

    <input type = "submit" value = "Envoyez"  style = "margin-left:5px" />
    </p>
    </form>
    
    
    <div id = "message_tele" style="margin-top:20px;">
    <?php
    if (!empty($messages_form_photo))
	{
		echo '<p>';
		foreach ($messages_form_photo as $num)
		{
				foreach ($num as $value)
				echo htmlspecialchars($value).'<br />';
		}
		echo '</p>';
	}
    
    if (!empty($messages_form_pdf))
	{
		echo '<p>';
		foreach ($messages_form_pdf as $num)
		{
				foreach ($num as $value)
				echo htmlspecialchars($value).'<br />';
		}
		echo '</p>';
	}
    ?>
    </div>
</div>   
 
 
<div style="margin-top:50px">
	<p>
	<?php
    // Lecture du tableau des résultats (se trouve ici uniquement pour la démonstration et visualiser la structue des tableaux de résultat)
    if (!empty ($transfert_form_photo))
	{
		$identifant = $transfert_form_photo['identifiant'];
		$champ = $transfert_form_photo['champ'];      
		$resultat = $transfert_form_photo['resultat'];//tableau à trois dimensions  

		echo $identifant.' :<br /><br />';

		foreach ($resultat as $num => $rep)
		{
			foreach ($rep as $key => $value)
			{                                                      
				if(!empty($value['nom']))                                  
				echo 'champ '.$champ.' n° '.$num.' = '.$value['nom'].' '. $value['dim'].', téléchargé dans "'.$key.'"<br />';
			}    
		}
	} ?>
    </p>
    
    <p>
    <?php
    // Lecture du tableau des résultats (se trouve ici uniquement pour la démonstration et visualiser la structue des tableaux de résultat)
    if (!empty ($transfert_form_pdf))
	{
		$identifant = $transfert_form_pdf['identifiant'];
		$champ = $transfert_form_pdf['champ'];        
		$resultat = $transfert_form_pdf['resultat'];//tableau à trois dimensions  

		foreach ($resultat as $num => $rep)
		{
			foreach ($rep as $key => $value)
			{                                                          
				if(!empty($value['nom']))                                  
				echo 'champ '.$champ.' n° '.$num.' = '.$value['nom'].' '. $value['dim'].', téléchargé dans "'.$key.'"<br />';
			}    
		}
	} ?>
	</p>
</div>
<div style="margin-top:50px">
Exemple avec plusieurs instanciations de la classe pour traiter des champs différents à destination de répertoires différents dans un même formulaire.<br>
<br>

Utilisation de Set_Redim dans sa configuration simple : les fichiers sont redimensionnés et téléchargés dans des répertoires différents avec le même nom.
</div>

</body>
</html>