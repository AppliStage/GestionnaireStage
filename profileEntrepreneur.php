<?php

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
    //Desactive certaines fonctions sur la page si l'entrepreneur n'a pas d'entreprise
    (sizeof($user->getEntreprises())== 0)? $etat="" : $etat="disabled";

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
                <div class="col-md-3">
                    <div class="list-group">
                      <button type="button" data-toggle="tab" data-target="#profile" data-target="#1profile" class="list-group-item">Profile</button>
                      <button type="button" data-toggle="tab" data-target="#ajout" class="list-group-item">Ajouter une entreprise</button>
                      <button type="button" data-toggle="tab" data-target="#entreprises{$etat}" class="list-group-item {$etat}">Mes entreprises</button>
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
                                    <label for="exampleInputEmail1">Nom</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="{$user->getNom()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Prenom</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="{$user->getPrenom()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="{$user->getMail()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Fonction</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="{$user->getFonction()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Telephone</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="{$user->getTel()}">
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
                                    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="{$user->getNom()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="exampleInputEmail1" placeholder="{$user->getPrenom()}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="{$user->getMail()}">
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

                          <div class="panel panel-default " >
                            <div class="panel-heading">
                              <h3 class="panel-title"><strong>Entreprises</strong></h3>
                            </div>
                            <div class="panel-body">                       
                              ...
                            </div>
                          </div>

                        </div> <!-- end tab Content -->

                        <div class="tab-pane fade in " id="ajout">

                          <div class="panel panel-default " >
                            <div class="panel-heading">
                              <h3 class="panel-title"><strong>Ajouter une entreprise</strong></h3>
                            </div>
                            <div class="panel-body">                       
                              <div class="jumbotron"> <!-- Ajout d'une entreprise -->
                                  <div class="row">
                                    <div class="col-xs-6 ">
                                      <a href="#" class="thumbnail">
                                        <img src="style/glyphicons_free/thumbnail.png" alt="image par default">
                                      </a>
                                          <label for="mon_fichier">Upload un logo: </label>
                                          <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                                          <input type="file" name="mon_fichier" id="mon_fichier" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <form >
                                      <div class="col-xs-6 ">
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">Nom</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputPassword1">Site internet</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ex: exemple.site.fr">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputPassword1">Telephone</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder=" 06 00 00 00 00 ">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputPassword1">Pays</label>
                                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">codePostale</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="ex: 51100">
                                          </div>
                                          <button type="submit" class="btn btn-success "><strong>Ajouter l'entreprise</strong></button>
                                      </div>
                                      <div class="col-xs-6 ">
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">Ville</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Reims">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">SIREN</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">SIRET</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">typeJurydique</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">codeAPE</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
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


