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

// redimensionnements
$up->Set_Redim ('200','150', array('_min'));

$up->Set_Redim ('1000','800',array('_max'));

// Renommage incrémentiel en cas de doublons (le contrôle se fera sur nomdufichier_min.jpg)
$up->Set_Renomme_fichier('incr');


$up->Upload('reload');


$messages_upload = $up->Get_Tab_message();
$messages_upload_html = null;
foreach ($messages_upload as $num) foreach ($num as $value) $messages_upload_html .= '<p>- '.htmlspecialchars($value).'</p>';

$tableau_resultat = $up->Get_Tab_result();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Redimentionnements avec suffixes ou préfixes</title>
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
body {font-family:Arial, Helvetica, sans-serif; font-size:12px;}
</style>
</head>
<body>
	<form enctype = "multipart/form-data" action = "#" method = "post" onsubmit = "Verif_attente('message_tele')">		
	<input name = "photo[]" type = "file" multiple = "multiple" size = "70" /><br />	 
 	<input  type="submit" value="Envoyer les images" id="envoyer" name = "form1"><br />
    </form>
 
     <div id = "message_tele" style="margin-top:20px;">
    <?= $messages_upload_html; ?>
    </div>
   
    
    <div style="margin-top:50px">
    <?php if(!empty($tableau_resultat))
    {
        echo 'tableau des résultats :';
        echo '<pre>';
        print_r($tableau_resultat);
        echo '</pre>';
    }
    ?>
    </div>
</body>
</html>