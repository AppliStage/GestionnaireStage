<?php
include_once "myPDO.include.php";
include_once "class/stage.class.php";

 if(isset($_REQUEST['poste']) && isset($_REQUEST['ville']) && isset($_REQUEST['domaines'])){
        
        $domaines = explode(",", $_REQUEST['domaines']);
        if ($domaines[0]=="") $domaines=array();
        $pdo = myPDO::getInstance();

        $addedSQL="  
        SELECT numStage AS 'id', titre, dateFin, dateDebut, description, domaine, nbPoste, gratification, s.numEntreprise as 'entreprise', dateCreation
          FROM Stage s, Entreprise e
          WHERE s.numEntreprise = e.numEntreprise
          AND upper(s.titre) LIKE concat('%', upper(?) , '%')
          AND (upper(e.ville) LIKE concat('%', upper(?) , '%')
          OR upper(e.pays) = upper(?))";
        
        $tab=array($_REQUEST['poste'], $_REQUEST['ville'], $_REQUEST['ville']);
        for($i=0; $i < sizeof($domaines); $i++) {
            $addedSQL .= " AND upper(s.domaine) LIKE concat('%', upper(?) , '%')";
            $tab[] = $domaines[$i];
        }

        $req = $pdo->prepare($addedSQL);
        //var_dump($req);
        //var_dump($tab);
        $req->execute($tab);
        /*$req->execute(array(':poste' => $_REQUEST['poste'], 
                            ':ville' => $_REQUEST['ville']));*/
        $listStage = $req->fetchAll(PDO::FETCH_CLASS, "Stage");

        $html="";
        //var_dump($entreprise);
        //Chaques entreprise crée a comme observeur l'entrepreneur passer en parametre
        foreach($listStage as $key => $stage){
        	$entreprise = Entreprise::creatFromId($stage->getEntreprise());
            $numEntreprise = $entreprise->getId();
        	$titre = htmlspecialchars ($stage->getTitre());
        	$nom = htmlspecialchars ($entreprise->getNom());
        	$ville = htmlspecialchars ($entreprise->getVille());
        	$pays = htmlspecialchars ($entreprise->getPays());
			$id = $stage->getId();
          	$html .="<tr><th scope='row'>{$id}</th> <td><a href='displayEntreprise.php?id={$numEntreprise}'>{$nom}</a></td> <td><a href=\"viewStage.php?id={$id}\">{$titre}</a></td> <td>{$pays}, {$ville}</td> </tr> </a>";
        }

        echo $html;

 }