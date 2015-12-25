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

$p->appendCssUrl("style/bootstrap-3.3.5-dist/css/bootstrap.min.css");
$p->appendCssUrl("style/signup.css");

$formConnexion = Utilisateur::loginFormSHA1("cible.php");

$p->appendContent(<<<HTML
    <div class="container">

    	{$formConnexion}

    	<div id="alert" class="alert alert-danger collapse" role="alert">
    		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    		<strong>Hmm... Le login et le mot de passe ne correspond à aucun compte connue.</strong>
    		<button type="button" class="btn btn-danger">J'ai oublié mon mot de passe</button>
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

