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

//$p->appendJsUrl('js/request.js') ;
$p->appendJsUrl("js/sha1.js");

//inclusion de la barre de navigation
include_once "navbar.inc.php";

//Gestion des réponse de l'enregistrement d'un entrepreneur
if(isset($_GET['ins'])){
	if($_GET['ins']=="true") {
		$action="success";
		$contenu = "Merci de vous être enregistré. Un mail de confirmation vous à été envoyé pour confirmer votre inscription.";
	}else{
		$action="danger";
		$contenu = "Nous ne pouvons pas vous enregistrer. Cette adresse mail a déjà été utilsé.";
	}
}

$p->appendContent(<<<HTML

    <div class="container">

      <form class="form-signin" name="inscription" method="POST" action="enregistrement.php">
        <h2 class="form-signin-heading">Inscrivez vous</h2>

        <label for="inputNom" class="sr-only">Nom: </label>
        <input type="text" id="inputNom" name = "nom" class="form-control" placeholder="Nom" pattern="[a-zA-Z].+" required>
        <label for="inputPrenom" class="sr-only">Prenom: </label>
        <input type="text" id="inputPrenom" name="prenom" class="form-control" placeholder="Prenom" pattern="[a-zA-Z].+"required>
        <label for="inputEmail3" class="sr-only">Email: </label>
        <input type="email" class="form-control" name="mail" id="inputEmail3" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
        <label for="inputPassword3" class="sr-only">Password</label>
        <input type="password" class="form-control"  name ="pass" id="inputPassword3" placeholder="Password" pattern="[0-9A-Za-z]{8,64}" required>
        <label for="inputEmail3" class="sr-only">Tel: </label>
        <input type="tel" class="form-control" id="inputTel" placeholder="Téléphone" name="tel" >
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
      </form>

				<!--<form class="form-horizontal" name="inscription" method="POST" action="enregistrement.php">
					<h2 class="form-signup-heading">Inscrivez vous</h2>
					  <div class="form-group">
					    <label for="inputNom" class="col-sm-2 control-label">Nom: </label>
					    <div class="col-sm-10">
					      <input type="text" id="inputNom" name = "nom" class="form-control" pattern="[a-zA-Z].+" required>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputPrenom" class="col-sm-2 control-label">Prenom: </label>
					    <div class="col-sm-10">
					      <input type="text" id="inputPrenom" name="prenom" class="form-control" pattern="[a-zA-Z].+"required>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Email: </label>
					    <div class="col-sm-10">
					      <input type="email" class="form-control" name="mail" id="inputEmail3" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-sm-10">
					      <input type="password" class="form-control"  name ="pass" id="inputPassword3" pattern="[0-9A-Za-z]{8,64}" required>
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Tel: </label>
					    <div class="col-sm-10">
					      <input type="tel" class="form-control" id="inputTel" name="tel" >
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
				</form>-->
	    <div id="alert" class="alert alert-{$action} collapse" role="alert">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	        <strong>{$contenu}</strong>
	    </div>
    </div> <!-- /container -->
HTML
	);

$p->appendContent("");


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

$p->appendToFooter(<<<Footer
    <script>
    	$(document).ready(function(){
        	$('#alert').show();
    	});
    </script>
Footer
);



/*
$p->appendJS(<<<JS
window.onload = function () {
    // Désactivation de l'envoi du formulaire
    //document.forms['inscription'].onsubmit = function () { return false ; }

	document.forms['inscription'].elements['submit'].onclick = function(){
		var form = document.forms['inscription'];

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

        new Request(
            {
                url        : "enregistrement.php",
                method     : 'get',
                handleAs   : 'text',
                parameters : { nom : varnom , prenom : varprenom , mail : varmail , pass : varpass, tel : vartel },
                onSuccess  : function(res) {
                		alert(res);
                		document.getElementsByClassName('bg-danger hidden')[0].className = "bg-danger hidden";
                        document.getElementsByClassName('bg-sucess hidden')[0].className = "bg-success show";
                    },
                onError    : function(status, message) {
                		document.getElementsByClassName('bg-sucess hidden')[0].className = "bg-success hidden";
                        document.getElementsByClassName('bg-danger hidden')[0].className = "bg-danger show";
                    }
        }) ;
		
	}

}
JS
);*/

echo $p->toHTML();
