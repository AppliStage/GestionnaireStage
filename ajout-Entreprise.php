<?php
include_once 'class/utilisateur.class.php';
include_once 'autoload.inc.php';
include_once 'class/entrepreneur.class.php';

if(isset($_GET['nom']) && isset($_GET['site']) && isset($_GET['tel']) && isset($_GET['pays']) &&isset($_GET['codePostal']) && isset($_GET['SIREN']) &&
 isset($_GET['SIRET']) && isset($_GET['codeAPE']) && isset($_GET['adresse']) && isset($_GET['ville']) && isset($_GET['typeJurydique']) ){

	//transformation de l'url donnée
	preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $_GET['site'], $site);

	if(preg_match ( "/^[0-9]{5}$/" , $_GET['codePostal'] ) &&
		preg_match ( "/^[0-9]{9}$/" , $_GET['SIREN'] ) &&
		preg_match ( "/^[0-9]{14}$/" , $_GET['SIRET'] ) &&
		$_GET['nom'] != "" &&
		$_GET['ville'] != "" &&
		$_GET['adresse'] != "") {

			if(Utilisateur::isConnected()){
				try{
					$user = Utilisateur::createFromSession();
					
					$entreprise = new Entreprise($_GET['nom'], $_GET['adresse'], $_GET['tel'], $_GET['typeJurydique'], $_GET['ville'],
					 			$_GET['pays'], $_GET['SIREN'], $_GET['SIRET'], $_GET['codeAPE'], $user, $_GET['codePostal'], $site);
					
					
					$entreprise-> setNom($_GET['nom']);
					$entreprise-> setTel($_GET['tel']);
					$entreprise-> setAdresse($_GET['adresse']);
					$entreprise-> setTypeJuridique($_GET['typeJurydique']);
					$entreprise-> setSite($site);
					$entreprise-> setPays($_GET['pays']);
					$entreprise-> setSIRET($_GET['SIRET']);
					$entreprise-> setSIREN($_GET['SIREN']);
					$entreprise-> setCodeAPE($_GET['codeAPE']);
					$entreprise-> setVille($_GET['ville']);
					$entreprise-> setCodePostal($_GET['codePostal']);
					$entreprise-> setEntrepreneur($user);

					$entreprise->save();
					header("Location: profileEntrepreneur.php?ins=true");
					exit;
				}catch(Exeption $e){
					echo $e->getMessage();
				}

			}
	}
}
header("Location: profileEntrepreneur.php?ins=false");

