<?php
include_once 'autoload.inc.php';
include_once 'init.inc.php';


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
$p->appendCssUrl("style/searchEngine.css");
$p->appendCssUrl("style/style.css");
$p->appendJsUrl("js/request.js");

//inclusion de la barre de navigation
include_once "navbar.inc.php";

$p->appendContent(<<<HTML

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Recherche de stage</h1>

          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#stages">Stages</a></li>
            <li><a data-toggle="tab" href="#recruteur">Espace Recruteur</a></li>
          </ul>

          <div class="tab-content" style="margin-top:15px;">

            <div id="stages" class="tab-pane fade in active">
              <div role="tabpanel" class="tab-pane active" id="stage">

                <form name="searchEngine" class="form-inline searchEngine" onSubmit="return false;">
                  <div class="form-group">
                    <input name ="poste" type="text" class="form-control" placeholder="Quel poste ?">
                  </div>
                  <div class="form-group">
                    <input name="ville" type="text" class="form-control" placeholder="Ville, Pays ...">
                  </div>
                  <button name="submit" type="submit" class="btn btn-default">Rechercher</button>

                  <!--Recherche Avancée -->
                  <a href="#" data-toggle="collapse" data-target="#demo" style="text-decoration:none;">Recherche avancée >></a>
                  <div id="demo" class="collapse">

                    <p class="bg-primary" style="margin-top:8px;"><strong><em>Formations: </em></strong></p>
                    <div class="row"> <!-- ROW 1 -->
                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="développement logiciel"> Développement logiciel
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="développement web"> Développement web
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input name="liste_select" type="checkbox" value="Commerce" > Commerce, vente, distribution
                          </label>
                        </div>
                      </div><!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="marketing"> Communication, Marketing, Media
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="informatique industrielle"> Informatique industrielle
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input name="liste_select" type="checkbox" value="réseau"> Réseau/Télécommunication
                          </label>
                        </div>
                      </div><!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="Sciences"> Sciences, technologies
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input name="liste_select" type="checkbox" value="Gestion"> Gestion, management
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input name="liste_select" type="checkbox" value="Ressource humaine"> Ressource humaine
                          </label>
                        </div>
                      </div><!--end Colone -->
                    </div> <!--end row 1-->


                  </div>
                </form>

              </div>
            </div>

            <div id="recruteur" class="tab-pane fade">
              <p>TO DO :</br>
                    - Select (entreprise) si l'user en a.<br/>
                    - formulaire pour crée un stage
              </p>
            </div>

          </div>

        </div>

HTML
);

$p->appendContent(<<<HTML
      <table class="table table-striped">
        <thead> 
          <tr> <th>Date</th> <th>Entreprise</th> <th>Intitulé du poste</th> <th>Lieu</th> </tr> 
        </thead> 
        <tbody id="liste_ajax"> 

        </tbody>
      </table>

      <nav style="text-align:center;"> 
        <ul class="pagination"> 

          <li class="disabled">
            <a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
          </li>
          
          <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> 
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li> 
          <li><a href="#">5</a></li> 

          <li>
            <a href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
          </li> 

        </ul> 
      </nav>

    </div> <!-- /container -->
HTML
);

$p->appendToFooter(<<<Footer
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="style/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
Footer
);

$p->appendToFooter(<<<JS
<script>
      // Fonction appelée au chargement complet de la page
    window.onload = function () {
              var valeurs = [];
              new Request(
                {
                    url        : "searchEngine.php",
                    method     : 'get',
                    handleAs   : 'text',
                    parameters : { poste: '%' , ville: '%', domaines: valeurs},
                    onSuccess  : function(res) {
                            document.getElementById("liste_ajax").innerHTML = res ;
                        },
                    onError    : function(status, message) {
                            window.alert('Error ' + status + ': ' + message) ;
                        }
                }) ;

        document.forms['searchEngine'].onsubmit = function () {return false ; }

          document.forms['searchEngine'].elements['submit'].onclick = function(){
            var form = document.forms['searchEngine'];
            var varPoste = form.elements['poste'].value;
            var varVille = form.elements['ville'].value;

            var valeurs = [];
            $('input:checked[name=liste_select]').each(function() {
              valeurs.push($(this).val());
            });
            console.log(valeurs);


            new Request(
              {
                  url        : "searchEngine.php",
                  method     : 'get',
                  handleAs   : 'text',
                  parameters : { poste: varPoste , ville: varVille, domaines: valeurs},
                  onSuccess  : function(res) {
                           document.getElementById("liste_ajax").innerHTML = res ;
                      },
                  onError    : function(status, message) {
                          window.alert('Error ' + status + ': ' + message) ;
                      }
              }) ;

          }


    }
</script>
JS
);

echo $p->toHTML();

