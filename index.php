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
$p->appendCssUrl("style/style.css");

//inclusion de la barre de navigation
include_once "navbar.inc.php";

$p->appendContent(<<<HTML

<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <h4>Oh ooups! </h4> 
      <p>Le login et le mot de passe ne correspond à aucun compte connue.</p> 
      <p>
        <button type="button" class="btn btn-danger">J'ai oublié mon mot de passe</button>
      </p>
    </div>
  </div>
</div>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Stage</h1>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>


        <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Stage</a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Espace Entrepreneur</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="stage">
              <form class="form-inline">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Quelle poste ?">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Ville, département, région ...">
                </div>
                <button type="submit" class="btn btn-default">Rechercher</button>
              </form>
            </div>

            <div role="tabpanel" class="tab-pane" id="espaceEntrepreneur">
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum</p>
            </div>
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
      $('#myModal').modal('toggle') 
    </script>
Footer
);

}

echo $p->toHTML();
