<?php
include_once 'class/entrepreneur.class.php';
include_once 'init.inc.php';
require_once "autoload.inc.php";


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
$p->appendCssUrl("style/profileStyle.css");

//inclusion de la barre de navigation
include_once "navbar.inc.php";


if($user instanceof Entrepreneur){
    //Desactive certaines fonctions sur la page si l'entrepreneur n'a pas d'entrepris
    $entreprises=  $user->getEntreprises();
    $listEntreprises ="";
    if($entreprises != null){
      $etat="" ;
      
      foreach ($entreprises as $key => $value) {
        $id= htmlspecialchars( $value->getId() );
        $nom = htmlspecialchars( $value->getNom() );
        $listEntreprises .= "<a href='entreprise.php?id={$id}' class='list-group-item'>{$nom}</a>";
      }
    }else{
      $etat="disabled";
    }

    
    $nom= htmlspecialchars( $user->getNom() );
    $prenom = htmlspecialchars( $user->getPrenom() );
    $mail = htmlspecialchars( $user->getMail() );
    $fonction = htmlspecialchars( $user->getFonction() );
    $tel = htmlspecialchars( $user->getTel() );

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
                <div class="col-md-3">
                    <div class="list-group">
                      <button type="button" data-toggle="tab" data-target="#profile" data-target="#1profile" class="list-group-item"><strong>Profile</strong></button>
                      <button type="button" data-toggle="tab" data-target="#ajout" class="list-group-item"><strong>Ajouter une entreprise</strong></button>
                      <button type="button" data-toggle="tab" data-target="#entreprises{$etat}" class="list-group-item {$etat}"><strong>Mes entreprises</strong></button>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="profile">
                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Profile</strong></h3>
                              </div>
                              <div class="panel-body">
                                <form>
                                  <div class="form-group">
                                    <label for="nomEntrepreneur">Nom</label>
                                    <input type="text" class="form-control" name="nomEntrepreneur" pattern="[a-zA-Z].+" placeholder="{$nom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="prenomEntrepreneur">Prenom</label>
                                    <input type="text" class="form-control" name="prenomEntrepreneur" pattern="[a-zA-Z].+" placeholder="{$prenom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="mailEntrepreneur">Email</label>
                                    <input type="email" class="form-control" name="mailEntrepreneur" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="{$mail}">
                                  </div>
                                  <div class="form-group">
                                    <label for="fontionEntrepreneur">Fonction</label>
                                    <input type="text" class="form-control" name="fontionEntrepreneur" placeholder="{$fonction}">
                                  </div>
                                  <div class="form-group">
                                    <label for="telEntrepreneur">Telephone</label>
                                    <input type="text" class="form-control" name="telEntrepreneur" placeholder="{$tel}">
                                  </div>
                                  <button type="submit" class="btn btn-success "><strong>Mise à jour</strong></button>
                                </form>
                              </div>
                            </div>

                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Changer le mot de passe</strong></h3>
                              </div>
                              <div class="panel-body">
                                <form>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Ancien mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputEmail1" >
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputEmail1" >
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputPassword1" >
                                  </div>
                                  <button type="submit" class="btn btn-success "><strong>Mettre à jour le mot de passe</strong></button>
                                </form>
                              </div>
                            </div>

                            <div class="panel panel-default" >
                              <div class="red panel-heading">
                                <h3 class="panel-title"><strong>Supprimer le compte</strong></h3>
                              </div>
                              <div class="panel-body">

                              </div>
                            </div>

                        </div><!-- end Profile-->

                        <div class="tab-pane fade in " id="entreprises">


                          <div class="list-group">
                            <a href="#" class="list-group-item disabled">
                             <h3 class="panel-title"><strong>Entreprises</strong></h3>
                            </a>
                            {$listEntreprises}
                          </div>

                          <!--<div class="panel panel-default " >
                            <div class="panel-heading">
                              <h3 class="panel-title"><strong>Entreprises</strong></h3>
                            </div>
                            <div class="panel-body">                       
                              ...
                            </div>
                          </div> -->

                        </div> <!-- end tab Content -->

                        <div class="tab-pane fade in " id="ajout">

                          <div class="panel panel-default " >
                            <div class="panel-heading">
                              <h3 class="panel-title"><strong>Ajouter une entreprise</strong></h3>
                            </div>
                            <div class="panel-body">                       
                              <div class="jumbotron"> <!-- Ajout d'une entreprise -->
                                  <!--<div class="row">
                                    <div class="col-xs-6 ">

                                      <a href="#" class="thumbnail">
                                        <img src="style/images/thumbnail.png" alt="image par default">
                                      </a>
                                          <label for="logo">Upload un logo: </label>
                                          <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                                          <input type="file" name="logo" id="mon_fichier" />
                                    </div>
                                  </div>-->
                                  <div class="row">
                                    <form methode="GET" action="ajout-Entreprise.php">
                                      <div class="col-xs-6 ">
                                          <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" name="Nom de l'entreprise" placeholder="Nom" pattern="[a-zA-Z].+" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="site">Site internet</label>
                                            <input type="text" class="form-control" name="Site de l'entreprise" placeholder="ex: exemple.site.fr" >
                                          </div>
                                          <div class="form-group">
                                            <label for="tel">Telephone</label>
                                            <input type="text" class="form-control" name="tel" placeholder=" 06 00 00 00 00 " required>
                                          </div>
                                          <div class="form-group">
                                            <label for="pays">Pays</label>
                                            <input type="text" class="form-control" name="pays" placeholder="ex: France" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="codePostale">codePostale</label>
                                            <input type="text" class="form-control" name="codePostal" placeholder="ex: 51100" pattern="[0-9]{5}" required>
                                          </div>
                                          <button type="submit" class="btn btn-success "><strong>Ajouter l'entreprise</strong></button>
                                      </div>
                                      <div class="col-xs-6 ">
                                          <div class="form-group">
                                            <label for="ville">Ville</label>
                                            <input type="text" class="form-control" name="ville" placeholder="Reims" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="ville">Adresse</label>
                                            <input type="text" class="form-control" name="adresse" placeholder="ex: 4 chemin des roulier" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="<SIREN">SIREN</label>
                                            <input type="text" class="form-control" name="SIREN" placeholder="" pattern="[0-9]{9}" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="SIRET">SIRET</label>
                                            <input type="text" class="form-control" name="SIRET" placeholder="" pattern="[0-9]{14}" required>
                                          </div>
 
                                          <div class="form-group" >
                                            <label for="typeJurydique">typeJurydique</label>
                                            <select name="typeJurydique" required>
                                              <option value="SA">SA</option>
                                              <option value="SARL">SARL</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label for="codeAPE">codeAPE</label>
                                            <input type="text" class="form-control" name="codeAPE" placeholder="" required>
                                          </div>
                                      </div>
                                    </form>
                                  </div>

                              </div> <!-- end Ajout-->
                            </div>
                          </div>

                        </div> <!-- end tab Content -->


                    </div>
                </div>
            </div> <!-- end row -->
        </div>
HTML
    );

$p->appendToFooter(<<<Footer
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="style/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
    });
    </script>
Footer
);
echo $p->toHTML();

}


