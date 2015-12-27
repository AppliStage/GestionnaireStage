<?php
/* L'adresse des dossiers passés en paramètre à la fonction d'upload doit être fournie par rapport à la racine du serveur.

Suivant que vous êtes sur un serveur distant ou sur un serveur d'évaluation, et en supoosant que le dossier 'PHOTO' soit situé à la racine du site, vous devrez indiquer :

$dossier_photo = 'PHOTO';
ou
$dossier_photo = 'dossier_du_site/PHOTO';

Le code ci-dessous défini les adresses des dossiers de tests par rapport à la racine du serveur. Il est valide tant que ce fichier est situé au même niveau (dans le même répertoire) que les dossiers de tests.
*/

$adresse_racine = rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/';

$adresse_dossier_test = substr(dirname(__FILE__),strlen($adresse_racine));

// pour compatibilité window
//$adresse_dossier_test = str_replace('\\','/',$adresse_dossier_test);

//echo $adresse_dossier_test;

$dossier_photo = $adresse_dossier_test.'/PHOTO';
$dossier_photo_GF = $adresse_dossier_test.'/PHOTO_GF';
$dossier_photo_PF = $adresse_dossier_test.'/PHOTO_PF';
$dossier_pdf = $adresse_dossier_test.'/PDF';

