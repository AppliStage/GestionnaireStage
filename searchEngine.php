<?php
include_once "myPDO.include.php";
include_once "class/stage.class.php";

 if(isset($_REQUEST['recherche'])){

        $pdo = myPDO::getInstance();

        $req = $pdo->prepare(<<<SQL
          SELECT numStage AS "id", titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, numEntreprise as 'entreprise', dateCreation
          FROM Stage
          WHERE titre LIKE ?
SQL
        );
        $req->execute(array($_REQUEST['recherche']));
        $listStage = $req->fetchAll(PDO::FETCH_CLASS, "Stage");

        $html="";
        //var_dump($entreprise);
        //Chaques entreprise crée a comme observeur l'entrepreneur passer en parametre
        foreach($listStage as $key => $stage){
        	$entreprise = Entreprise::creatFromId($stage->getEntreprise());
        	$titre = htmlspecialchars ($stage->getTitre());
        	$nom = htmlspecialchars ($entreprise->getNom());
        	$ville = htmlspecialchars ($entreprise->getVille());
        	$pays = htmlspecialchars ($entreprise->getPays());
			$id = $stage->getId();
          	$html .="<tr><th scope='row'>{$key}</th> <td>{$nom}</td> <td><a href=\"viewStage.php?id={$id}\">{$titre}</a></td> <td>{$pays}, {$ville}</td> </tr> </a>";
        }

        echo $html;

 }