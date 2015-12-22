<?php
include_once 'autoload.inc.php';
include "class/utilisateur.class.php";
include "class/entrepreneur.class.php";


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

//inclusion de la barre de navigation
include_once "navbar.inc.php";

$p->appendContent(<<<HTML

    <div class="container">

      <div id="alert" class="alert alert-danger collapse" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Hmm... Le login et le mot de passe ne correspond à aucun compte connue.</strong>
        <button type="button" class="btn btn-danger">J'ai oublié mon mot de passe</button>
      </div>

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

                <form class="form-inline searchEngine">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Quelle poste ?">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Ville, département, région ...">
                  </div>
                  <button type="submit" class="btn btn-default">Rechercher</button>

                  <!--Recherche Avancée -->
                  <a href="#" data-toggle="collapse" data-target="#demo" style="text-decoration:none;">Recherche avancée >></a>
                  <div id="demo" class="collapse">

                    <p class="bg-primary" style="margin-top:8px;"><strong><em>Formation: </em></strong></p>
                    <div class="row"> <!-- ROW 1 -->
                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Assurance, Banque, Immobilier
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value="" > Commerve, vente, distribution
                          </label>
                        </div>
                      </div><!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Droit, Sc Politique, Economie
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value=""> Informatique, Télécom
                          </label>
                        </div>
                      </div><!--end Colone -->

                      <div class="col-md-4">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Sciences, technologies
                          </label>
                        </div>
                        <div class="checkbox ">
                          <label>
                            <input type="checkbox" value=""> Gestion, management, RH
                          </label>
                        </div>
                      </div><!--end Colone -->
                    </div> <!--end row 1-->

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

                  </div>
                </form>

              </div>
            </div>

            <div id="recruteur" class="tab-pane fade">
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
    		<tbody> 
    		  <tr> <th scope="row">1</th> <td>HSBC</td> <td>Servir le café</td> <td>France, Paris</td> </tr> 
    		  <tr> <th scope="row">2</th> <td>Lego</td> <td>Servir le café</td> <td>France, Toulouse</td> </tr>
    		  <tr> <th scope="row">3</th> <td>HBO</td> <td>Servir le café</td> <td>Chine, Chongqing </td> </tr>
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

if(isset($_GET['err']) && $_GET['err'] == "log"){
  $p->appendToFooter(<<<Footer
    <script>
      $(document).ready(function(){
          $('#alert').show();
          /*
          $(".nav-tabs a").click(function(){
              $(this).tab('show');
          });
          */
      });
    </script>
Footer
);

}

echo $p->toHTML();
