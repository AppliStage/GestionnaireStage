<?php
include_once 'class/utilisateur.class.php';
include_once 'autoload.inc.php';
include_once 'class/entrepreneur.class.php';
include_once 'init.inc.php';

var_dump($_REQUEST);
if(isset($_REQUEST['nomEntreprise']) && isset($_REQUEST['siteEntreprise']) && isset($_REQUEST['tel']) && isset($_REQUEST['pays']) &&isset($_REQUEST['codePostal']) && isset($_REQUEST['SIREN']) &&
 isset($_REQUEST['SIRET']) && isset($_REQUEST['codeAPE']) && isset($_REQUEST['adresse']) && isset($_REQUEST['ville']) && isset($_REQUEST['typeJurydique']) ){
	
	//transformation de l'url donnée
	preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $_REQUEST['siteEntreprise'], $site);


	if(preg_match ( "/^[0-9]{5}$/" , $_REQUEST['codePostal'] ) &&
		preg_match ( "/^[0-9]{9}$/" , $_REQUEST['SIREN'] ) &&
		preg_match ( "/^[0-9]{14}$/" , $_REQUEST['SIRET'] ) &&
		$_REQUEST['nomEntreprise'] != "" &&
		$_REQUEST['ville'] != "" &&
		$_REQUEST['adresse'] != "") {


			try{					
				$entreprise = new Entreprise($_REQUEST['nomEntreprise'], $_REQUEST['adresse'], $_REQUEST['tel'], $_REQUEST['typeJurydique'], $_REQUEST['ville'],
				 			$_REQUEST['pays'], $_REQUEST['SIREN'], $_REQUEST['SIRET'], $_REQUEST['codeAPE'], $user, $_REQUEST['codePostal'], $site);
						
						
				$entreprise-> setNom($_REQUEST['nomEntreprise']);
				$entreprise-> setTel($_REQUEST['tel']);
				$entreprise-> setAdresse($_REQUEST['adresse']);
				$entreprise-> setTypeJuridique($_REQUEST['typeJurydique']);
				$entreprise-> setSite($site);
				$entreprise-> setPays($_REQUEST['pays']);
				$entreprise-> setSIRET($_REQUEST['SIRET']);
				$entreprise-> setSIREN($_REQUEST['SIREN']);
				$entreprise-> setCodeAPE($_REQUEST['codeAPE']);
				$entreprise-> setVille($_REQUEST['ville']);
				$entreprise-> setCodePostal($_REQUEST['codePostal']);
				$entreprise-> setEntrepreneur($user);

				$entreprise->save();
				header("Location: profileEntrepreneur.php?ins=true");
				exit;
			}catch(Exeption $e){
				echo $e->getMessage();
			}

	}
}
header("Location: profileEntrepreneur.php?ins=false");

