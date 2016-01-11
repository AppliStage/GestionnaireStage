# GestionnaireStage

SRINT n°1 [FINI]
-----------------
	- Une connexion sécurisé
	- Implémenter l'inscription des utilisateurs
	- Restriction et espace membre (phpCAS)

SRINT n°2 [FINI]
-----------------
	- Crée une entreprise et faire des offres
	- Upload sécurisé des CV/Lettres, postuler 
	- Rechercher/Affichier par domaine, ville, etc.

SRINT n°3 
-----------------
	- Les enseignants doivent pouvoir commenter les entreprises.
	- Postuler et commenter doit être restreind aux profils complétés
	- L'administrateur a une interface pour attribuer des enseignants aux stages et
	  valider les conventions complétes
	- Les conventions peuvent être imprimer.

SCRUM du 08/01/2016: 
-----------------
Théo
Page profileURCA.php
	-Pour que le site reste responsive tout le contenu de la page sera affiché dans les balises de class ".col-sm-*" et "row"
		(voir http://getbootstrap.com/css/#grid )
	-La page comportera une partie affichant les détails de l'utilisateur (dans une pannel http://getbootstrap.com/components/#panels-heading.
		(voir http://getbootstrap.com/css/#type-addresses ,  http://getbootstrap.com/css/#type-alignment )
	-La seconde partie de la page est un formulaire pour modifier l'utilisateur.

Remi
Class Commentaire:
Page displayEntreprise.php
	-Pour que le site reste responsive tout le contenu de la page sera affiché dans les balises de class ".col-sm-*" et "row"
		(voir http://getbootstrap.com/css/#grid )
	-La page comportera une partie affichant les détails de l'entreprise  et son logo si elle en posséde un.
		(voir http://getbootstrap.com/css/#type-addresses ,  http://getbootstrap.com/css/#type-alignment )
	-La page contiendra un formulaire pour commenter ( un formulaire comme celui de viewStage.php )
	-La cible du formulaire vérifira que l'utilisateur ai les droits pour commenter
	-La fin de la page affiche les commentaires des enseignants ( voir http://getbootstrap.com/components/#media-alignment )

Quentin
Class Administrateur
	-Le mot de passe et l'adresse mail de l'administrateur est directement rentré dans la base de donnée 
	-L'administrateur n'est pas un singleton
	-Le constructeur prend en paramètre une adresse mail, un mot de passe et vérifie qu'ils correspondent avec une ligne dans la base de donné.
	-Les attributs de la class Utilisateurs seront remplis avec des valeurs null
	-Methode valideAffectation
	-Méthode Imprimer

Marvin & Renaud
Page administration.php
	-Pour que le site reste responsive tout le contenu de la page sera afficher dans les balises de class ".col-sm-*" et "row"
		(voir http://getbootstrap.com/css/#grid )
	-Cette page affiche toutes les conventions crées et les enseignants qui y sont attibués.
		(voir http://getbootstrap.com/components/#panels-tables )
	-Les conventions avec un enseignant auront un bouton pour valider la convention, les autres conventions auront un bouton grisé.
		(voir http://getbootstrap.com/css/#buttons-disabled )
		

Toolbox
-----------------
	-Crée un serveur web local :
		https://www.apachefriends.org/download.html
	-Comprendre le CAS :
		https://wiki.mdl29.net/doku.php?id=braveo:docinstall:cas:serviceweb#phpcasclient
		https://developer.jasig.org/cas-clients/php/1.0.1/docs/api/group__publicAuth.html#gcd9bd0c52d0c72a5d746365c4808527a
	-Ce que l'on veut faire avec le CAS :
		https://wiki.jasig.org/display/CAS/Using+CAS+without+the+Login+Screen
	 	https://wiki.mdl29.net/doku.php?id=braveo:docinstall:cas:proxying:presentation
	-Autres :
		http://getbootstrap.com/
		http://jobs-stages.letudiant.fr/stages-etudiants.html
		http://alumni-iutrcc.univ-reims.fr/arexis_ied/srv_stage_consult?view=accueil&idstage=0
		
