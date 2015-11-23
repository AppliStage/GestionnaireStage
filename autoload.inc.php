<?php
// Niveau d'erreur maximal pour développer
error_reporting(E_ALL | E_STRICT) ;

/** Tentative de chargement magique du fichier contenant la classe non définie
 * @param string $className Nom de la classe dont la définition manque
 *
 * @return void
 */
spl_autoload_register(function ($className) {
    // Nom du fichier = nom_de_la_classe.class.php
    $fichier = 'class/'.strToLower($className).'.class.php' ;
    // Existe ?
    if (file_exists($fichier))
        // Oui : l'inclure
        require_once($fichier) ;
    // Pour être compatible avec le système de gestion des corrections
    if (file_exists('../' . $fichier))
        // Oui : l'inclure
        require_once($fichier) ;
}
) ;

