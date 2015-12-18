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
    <p name="danger" class="bg-danger hidden">Le login ou le mot de passe est incorrect !</p>


    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Stage</h1>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p>
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
		  
		  <!--<tr> 
			<nav>
			  <ul class="pagination">
			<li>
			  <a href="#" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			  </a>
			</li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li>
			  <a href="#" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
			  </a>
			</li>
			  </ul>
			</nav>
		  </tr>-->
		</tbody>
      </table>

    </div> <!-- /container -->
HTML
);

$p->appendToFooter(<<<Footer
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="style/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="style/bootstrap-3.3.5-dist/js/ie10-viewport-bug-workaround.js"></script>
Footer
);
echo $p->toHTML();
