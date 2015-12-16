<?php
include 'autoload.inc.php';

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

if(isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['mail']) and isset($_POST['pass']) and isset($_POST['tel'])){
  $nom = $p->escapeString($_POST['nom']);
  $prenom = $p->escapeString($_POST['prenom']);
  $mail = $p->escapeString($_POST['mail']);
  $pass = $p->escapeString($_POST['pass']);
  $tel = $p->escapeString($_POST['tel']);
  
  if(!(Entrepreneur::inscription($nom,$prenom,$mail,$pass,$tel))){
    /* le code ici c'est celui si l'inscription n'a pas marché */
  }
  }
$p->appendCssUrl("style/bootstrap-3.3.5-dist/css/bootstrap.min.css");
$p->appendCssUrl("navbar-static/-top.css");
$p->appendCssUrl("style/signup.css");

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
          <ul class="nav navbar-nav navbar-right">
	    <li>
	      <form class="form-inline" style="padding-top:8px">
		<div class="form-group">
		  <label class="sr-only" for="exampleInputEmail3">Email address</label>
		  <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
		</div>
		<div class="form-group">
		  <label class="sr-only" for="exampleInputPassword3">Password</label>
		  <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
		</div>
		<button type="submit" class="btn btn-default">Sign in</button>
		<a class="btn btn-default" href="inscription.php" role="button">Sign up</a>
	      </form>
	    </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">

	<div class="jumbotron">
	  <h1>I.U.T rcc</h1>
		<div class="inlineP"> 
			<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum
			</p>
		</div>
			<form class="form-horizontal">
				<h2 class="form-signup-heading">Inscrivez vous</h2>
				  <div class="form-group">
				    <label for="inputNom" class="col-sm-2 control-label">Nom: </label>
				    <div class="col-sm-10">
				      <input type="text" id="inputNom" name = "nom" class="form-control" required>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPrenom" class="col-sm-2 control-label">Prenom: </label>
				    <div class="col-sm-10">
				      <input type="text" id="inputPrenom" name="prenom" class="form-control" required>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Email: </label>
				    <div class="col-sm-10">
				      <input type="email" class="form-control" name="mail" id="inputEmail3" required>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control"  name ="pass" id="inputPassword3" required>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Tel: </label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="inputTel" name="tel" >
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
					<label>
					  <input type="checkbox"> Remember me
					</label>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				    	<button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
				    </div>
				  </div>
			</form>
	</div>
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
