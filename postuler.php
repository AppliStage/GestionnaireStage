<?php

/* **************************************
 * Cette page n'affiche rien, elle fait que vérifer que tous les parametres sont réuni pour que le mail de l'étudiant soit 
 * envoyé. Les fichiers envoyé par le client sont dans $_FILE, la class upload nous permet de controler leur contenu.
 * 
 */

// initialise la variable $user 
require_once "init.inc.php";


require('class/upload/Classe_Upload.php');
require('class/upload/adresses_dossiers.php');


if(isset($_REQUEST['var']) && isset($_REQUEST['var']) && isset($_REQUEST['var']) && $user instanceof Etudiant){

	// Module d'upload -----------------------------------------------------------------------------------------------------------------------------------

	
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

}
else 
	header("Location: viewStage.php?postuler=false");

