<?php

/* **************************************
 * Cette page n'affiche rien, elle fait que vérifer que tous les parametres sont réuni pour que le mail de l'étudiant soit 
 * envoyé. Les fichiers envoyé par le client sont dans $_FILE, la class upload nous permet de controler leur contenu.
 * 
 */
include_once "class/etudiant.class.php";
include_once "class/entrepreneur.class.php";
include_once "class/stage.class.php";
//include_once "class/enseignant.class.php";
include_once "myPDO.include.php";

// initialise la variable $user 
require_once "init.inc.php";

require('class/upload/Classe_Upload.php');
require('class/upload/adresses_dossiers.php');

if($user instanceof Etudiant){

	/*TO DO :
	 * - Restreindre les fichier à une taille maximun et modifier le controle pour le fichier soit un PDF
	 */

	// Module d'upload -----------------------------------------------------------------------------------------------------------------------------------

	// Déclaration de la classe avec envoi des paramètres (cf doc)
	$form = new Telechargement ($dossier_pdf,'envoi_file','photo','get_form');

	// option : contrôle que le fichier est une image de type gif, jpg, jpeg ou png (et retourne ses dimensions dans le tableau des résultats - tableau non exploité dans l'exemple ci-dessous)
	//$form->Set_Controle_dimImg ();

	// option : contrôle que le fichier est un pdf
	$extensions = array('pdf');
	$form->Set_Extensions_accepte ($extensions);

	//Controle la taille du fichier uploader
	$form->Set_Max_poidsFicher('1 Mo');

	//Defini le nom des fichier téléchargé 
	$nomFichier = time().'';
	$form->Set_Nomme_fichier($nomFichier, 'pdf');

	//option pour renommer le fichier en mode incrémentiel si un fichier de même nom existe déjà sur le serveur
	$form->Set_Renomme_fichier('incr');

	//Téléchargement sans traitement php supplémentaire -> on spécifie un rechargement de la page suite au téléchargement en indiquant un argument non nul ex 'reload' dans la fonction d'Upload.
	$form->Upload ();
	
	// Enregistrement des messages de contrôle
	$messages_form = $form->Get_Tab_message ();
	 
	$config_serveur = $form->Return_Config_serveur('tableau');
	$max_fichier_serveur = $config_serveur['upload_max_filesize'];
	$max_post_serveur = $config_serveur['post_max_size'];
	//----------------------------------------------------------------------------------------------------------------------------------------------------


	/*
	* TO DO :
	* - (* potentiellement terminé *) Recuperer l'adresse mail de l'employeur grace a l'id du stage $_REQUEST['id']
	* - Crée un mail en rajoutant les fichiers téléchargés au centent-type (piece jointe)
	* - envoyer le mail  mail($destinataire, $titreDuMail, $message, $entete);
	* - Ajouter le stage à la listes de stage de l'etudiant (Ajoute ue ligne sur la table postuler en meme temps)
	* - Supprimer le fichier grace à la class File
	*/
	
	// récupérer mail
	
	$id = $_REQUEST['id'];
	$pdo = myPDO::getInstance();

	
	$rq1 = $pdo->prepare(<<<SQL
	SELECT eeur.mail
	FROM Stage s, Entreprise eise, Entrepreneur eeur
	WHERE s.numEntreprise = eise.numEntreprise
	  AND eise.numEntrepreneur = eeur.numEntrepreneur
	  AND s.numStage = ?
SQL
	);
	$rq1->execute(array($id));
	$adresseMail = $rq1->fetch();
	
	// création mail
	
	require_once('class/mail/class.phpmailer.php');

	$email = new PHPMailer();

	//Set who the message is to be sent from
	$email->setFrom($user->getMail(), $user->getNom() . " " . $user->getPrenom());
	//Set an alternative reply-to address
	$email->addReplyTo($user->getMail(), $user->getNom() . " " . $user->getPrenom());	
	$email->addAddress($adresseMail);
	$email->isHTML(true); 
	$email->Subject = $_REQUEST['titre'];
	$email->Body = $_REQUEST['contenu'];


/*
	$listFichiers = scandir ($dossier_pdf);
	while (false !== ($entry = readdir($dossier_pdf))) {
			if(fnmatch ($nomFichier."*", $entry)){
				$email->AddAttachment( $dossier_pdf.$entry );
				unlink ($dossier_pdf.$entry ); //Supprime le fichier
			}
    }
	*/
	// envoi mail 
	$email->Send();

	// mise à jour de la base de données
	$user->postulerStage(Stage::creatFromId($_REQUEST['id']));

	header("Location: viewStage.php?id={$_GET['id']}&postuler=true");
}
else 
	header("Location: viewStage.php?id={$_GET['id']}&postuler=false");

