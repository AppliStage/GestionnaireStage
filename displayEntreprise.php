<?php
require_once 'class/entreprise.class.php';
require_once "autoload.inc.php";
require_once "init.inc.php";

$p = new webpage("Iut Stage");
$p->appendToHead(<<<head
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
head
);

$p->appendCssUrl("style/bootstrap-3.3.5-dist/css/bootstrap.min.css");
//inclusion de la barre de navigation
include_once "navbar.inc.php";

if (isset($_REQUEST['id']) &&  ($entreprise = Entreprise::creatFromId($_REQUEST['id'])) != null){

    $nom = htmlspecialchars ($entreprise->getNom());
    $adr = htmlspecialchars ($entreprise->getAdresse());
    $tel = htmlspecialchars ($entreprise->getTel());
    $typeJurydique = htmlspecialchars ($entreprise->getTypeJuridique());
    $site = htmlspecialchars(($entreprise->getSite() != null)? $entreprise->getSite() : "" );
    $pays = htmlspecialchars($entreprise->getPays()); 
    $siret = htmlspecialchars($entreprise->getSIRET()); 
    $siren = htmlspecialchars($entreprise->getSIREN()); 
    $ville = htmlspecialchars($entreprise->getVille()); 
    $codePostal = htmlspecialchars($entreprise->getCodePostal()); 

    //Affiche tous les avis sur l'entreprise
    $commentaires ="";
    foreach ($entreprise->getAvis() as $key => $value) {
        $nomEnseignant = htmlspecialchars($value->getEnseignant());
        $contenu = htmlspecialchars($value->getContenu());
        $commentaires .=<<<AVIS
            <div class="media">
              <div class="media-left media-middle">
                <a href="#">
                  <img class="media-object" src="style/images/icone-enseignant.png" alt="Images Professeur" style="width:64px;">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">{$nomEnseignant}</h4>
                {$contenu}
              </div>
            </div>
AVIS;
    }



    $p->appendContent(<<<HTML

        <div class="container"> <!-- CONTIENT TOUTE LA PAGE -->
                <div class="row">  
                    <div class="col-md-12">

                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h2 class="panel-title"><strong>Informations sur {$nom} </strong></h2>
                          </div>
                          <div class="panel-body">
                            <div class="col-md-6">
                                <address>
                                  <strong>
                                    {$adr}, {$pays}<br>
                                    {$ville}, {$codePostal}<br>
                                    Site : {$site}</br/>                         
                                    Tel : {$tel}<br/></br/>
                                    
                                  </strong>


                                  <strong>Type Juridique : </strong>{$typeJurydique}<br/>
                                  <strong>SIREN : </strong>{$siren}<br/>
                                  <strong>SIRET : </strong>{$siret}<br/>

                                </address>
                            </div>
                            <div class="col-md-6">

                            </div>

                          </div>
                        </div>

                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="page-header" style="text-align:center;margin-top:70px">
                        </div>

                        <form action = "commenter.php?id={$_REQUEST['id']}" method = "get">
                            <div class="row">  <!-- Il ne peut y avoir qu'une seul class container par page -->
                                <label for="contenu">Contenu du mail: </label>
                                <textarea name="contenu" class="form-control" rows="3" placeholder=""></textarea>
                            </div>
                            <div class="row" style="text-align:right;margin-top:8px"> 
                                <button class="btn btn-default" >Annuler</button>                            
                                <button class="btn btn-primary" type="submit">Publier</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row"> 
                    {$commentaires}
                </div>

        </div>

HTML
    );

}

$p->appendToFooter(<<<Footer
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="style/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
Footer
);

echo $p->toHTML();


