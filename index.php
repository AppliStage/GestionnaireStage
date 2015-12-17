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
$p->appendCssUrl("navbar-static/-top.css");
$p->appendCssUrl("style/style.css");

$p->appendContent(<<<HTML
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">GestionnaireStage</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
HTML
);
			if (!Utilisateur::isConnected())
				$p->appendContent(Entrepreneur::loginFormSHA1("cible.php"));
			else{
				$p->appendContent(<<<HTML
			<ul class="nav navbar-nav navbar-right">
				<li>
				  <form method="POST" action="logoff.php" name="connexion" class="form-inline" style="padding-top:8px">
					<button type="submit" class="btn btn-default" name="logout">Déconnexion</button>
				  </form>
				</li>
	        </ul>
HTML
);
			}

$p->appendContent(<<<HTML
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <p name="danger" class="bg-danger hidden">...</p>


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
/*
$p->appendJS(<<<JS
window.onload() = function {

  document.forms['connexion'].elements['login'].onclick = function() {
  
	new Request({
	
	  url : "."
	  method : "post"
	  onSuccess : function(res) {
		
		document.getElementById("success").className = "bg-success show";
		window.setTimeout(
		  document.getElementById("success").className = "bg-success hidden",
		  8000
		  
		);
		
	  }
	  
	  onError : function(status, message) {
	  
		document.getElementById("danger").className = "bg-danger show";
		window.setTimeout(
		  document.getElementById("danger").className = "bg-danger hidden",
		  8000
		  
		);
	  
	  }
	
	});
  
  }

}


JS
);
*/
echo $p->toHTML();
