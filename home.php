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
$p->appendJsUrl("js/request.js");

//inclusion de la barre de navigation
include_once "navbar.inc.php";

$p->appendContent(<<<HTML

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Stage</h1>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>

          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#stages">Stages</a></li>
            <li><a data-toggle="tab" href="#recruteur">Espace Recruteur</a></li>
          </ul>

          <div class="tab-content" style="margin-top:15px;">

            <div id="stages" class="tab-pane fade in active">
              <div role="tabpanel" class="tab-pane active" id="stage">

                <form name="searchEngine" class="form-inline searchEngine" onSubmit="return false;">
                  <div class="form-group">
                    <input name ="poste" type="text" class="form-control" placeholder="Quelle poste ?">
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
                            <input name="liste_select" type="checkbox" value="Assurance"> Assurance, Banque
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="Immobilier"> Immobilier
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
                            <input name="liste_select" type="checkbox" value="Droit"> Droit, Sc Politique
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="liste_select" type="checkbox" value="Economie"> Economie
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input name="liste_select" type="checkbox" value="Informatique"> Informatique, Télécom
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

if (Utilisateur::isConnected()){
	try{
		$user = Utilisateur::createFromSession();
		$p->appendContent("<h1>Bonjour ".$user->getNom()."(test)</h1>");	
	}catch(Exception $e){}
}

$p->appendContent(<<<HTML
      <table class="table table-striped">
    		<thead> 
    		  <tr> <th>#</th> <th>Entreprise</th> <th>Intitulé du poste</th> <th>Lieu</th> </tr> 
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


  /*

      // Désactivation de l'envoi du formulaire
    //document.forms['searchEngine'].onsubmit = function () { return false ; }
  document.forms['searchEngine'].elements['submit'].onclick = function(){
    var form = document.forms['searchEngine'];

    var varnom = form.elements['nom'].value;
      form.elements['nom'].value = "";
      var varprenom = form.elements['prenom'].value; 
      form.elements['prenom'].value=""; 
      var varmail = form.elements['mail'].value;
      form.elements['mail'].value=""; 
      var varpass = SHA1(form.elements['pass'].value); 
      form.elements['pass'].value=""; 
      var vartel = form.elements['tel'].value;
      form.elements['tel'].value=""; 

      function crypter(){
        new Request(
            {
                url        : "searchEngine.php",
                method     : 'get',
                handleAs   : 'text',
                parameters : { nom : varnom , prenom : varprenom , mail : varmail , pass : varpass, tel : vartel },
                onSuccess  : function(res) {
                    document.getElementsByClassName('resRecherche').innerHTML = res;
                    },
                onError    : function(status, message) {
                    // ...
                    }
        }) ;
      }
  }*/


/*
                    <p class="bg-primary" style="margin-top:8px;"><strong><em>En France: </em></strong></p>
                    <div class="row"> <!-- ROW 2 -->
                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Alsace
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Aquitaine
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Auvergne
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Basse-Normandie
                          </label>
                        </div>
                      </div> <!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Bourgogne
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Bretagne
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Champagne-Ardenne
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Corse
                          </label>
                        </div>
                      </div><!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value=""> Haute-Normandie
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > île-de-France
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Limousin
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Lorraine
                          </label>
                        </div>
                      </div><!--end Colone -->
                    </div> <!--end row 2-->
                    */