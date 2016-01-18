<?php
require_once "autoload.inc.php";
include_once "init.inc.php";

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

if($user instanceof Etudiant || $user instanceof Enseignant){

    $nom= htmlspecialchars( $user->getNom() );
    $prenom = htmlspecialchars( $user->getPrenom() );
    $mail = htmlspecialchars( $user->getMail() );
    $tel = htmlspecialchars( $user->getTel() );


  //Gestion des réponse de l'enregistrement d'un entrepreneur
  if(isset($_GET['err'])){
    $toggleScript="$('#alert').show();";
    if($_GET['err'] == 'compteImcomplet' && $user instanceof Enseignant){
      $action="danger";
      $contenu = "Les champs précédé de '*' doivent être rempli pour commenter une entreprise.";
    }
    else{
      $action="danger";
      $contenu = "Les champs précédé de '*' doivent être rempli postuler à un stage.";
    }

  }
  else{
    $toggleScript="";
    $action ="";
    $contenu ="";
  }
  
  
  $p->appendJs(<<<JS
  
  function controlInfo(){
  
       if(document.getElementById('nom').value.match(/[A-Za-z]/)==null && document.getElementById('nom').value != ""){
	  document.getElementById('formNom').classList.add("has-error");
	  if(document.getElementById('formNom').classList.contains("has-success")){
		document.getElementById('formNom').classList.remove("has-success");
	  }
       }else{
	    if(document.getElementById('nom').value != ""){
	      document.getElementById('formNom').classList.add("has-success");
	      if(document.getElementById('formNom').classList.contains("has-error")){
		document.getElementById('formNom').classList.remove("has-error");
	      }
	    }
       }
       
       if(document.getElementById('prenom').value.match(/[A-Za-z]/)==null && document.getElementById('prenom').value != ""){
	  document.getElementById('formPrenom').classList.add("has-error");
	  if(document.getElementById('formPrenom').classList.contains("has-success")){
		document.getElementById('formPrenom').classList.remove("has-success");
	      }
       }else{
	  if(document.getElementById('prenom').value != ""){
	    document.getElementById('formPrenom').classList.add("has-success");
	    if(document.getElementById('formPrenom').classList.contains("has-error")){
		document.getElementById('formPrenom').classList.remove("has-error");
	      }
	  }
       }
       
       if(document.getElementById('mail').value.match(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/)==null && document.getElementById('mail').value != ""){
	  document.getElementById('formMail').classList.add("has-error");
	  if(document.getElementById('formMail').classList.contains("has-success")){
		document.getElementById('formMail').classList.remove("has-success");
	      }
       }else{
	  if(document.getElementById('mail').value != ""){
	    document.getElementById('formMail').classList.add("has-success");
	    if(document.getElementById('formMail').classList.contains("has-error")){
		document.getElementById('formMail').classList.remove("has-error");
	      }
	  }
       }
       
       if(document.getElementById('tel').value.match(/(0|\\+33|0033)[1-9][0-9]{8}/) == null && document.getElementById('tel').value != ""){
	  document.getElementById('formTel').classList.add("has-error");
	  if(document.getElementById('formTel').classList.contains("has-success")){
		document.getElementById('formTel').classList.remove("has-success");
	    }
       }else{
       
	  if(document.getElementById('tel').value != ""){
	    document.getElementById('formTel').classList.add("has-success");
	    if(document.getElementById('formTel').classList.contains("has-error")){
		document.getElementById('formTel').classList.remove("has-error");
	    }
	  }
       }
  }
JS
  );

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
                <div id="alert" class="alert alert-{$action} collapse" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{$contenu}</strong>
                </div>


                <div class="col-md-12">
                    <div class="tab-content">
                			<div class="tab-pane fade in active" id="profile">
                 			   <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Information Profile : {$user->getId()}</strong></h3>
                              </div>
                              <div class="panel-body">
                        			  <strong>Nom : </strong>{$nom}<br>
                        				<strong>Prénom : </strong>{$prenom}<br>
                        				<strong>Adresse mail : </strong>{$mail}<br>
                        				<strong>Téléphone : </strong>{$tel}
                              </div>
                            </div>

                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Modification Profile</strong></h3>
                              </div>
                              <div class="panel-body">
                                <form  method="POST" action="updateProfile.php">
                                  <div class="form-group" id="formNom">
                                    <label for="nomEtudiant">Nom*</label>
                                    <input type="text" class="form-control" id="nom" name="nom" pattern="[a-zA-Z].+" placeholder="{$nom}" value="{$nom}" onChange="controlInfo()">
                                  </div>
                                  <div class="form-group" id="formPrenom">
                                    <label for="prenomEtudiant">Prenom*</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" pattern="[a-zA-Z].+" placeholder="{$prenom}" value="{$prenom}" onChange="controlInfo()">
                                  </div>
                                  <div class="form-group" id="formMail">
                                    <label for="mailEtudiant">Email*</label>
                                    <input type="email" class="form-control" id="mail" name="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="{$mail}" value="{$mail}" onChange="controlInfo()"> 
                                  </div>
                                  <div class="form-group" id="formTel">
                                    <label for="telEtudiant">Telephone</label>
                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="{$tel}" value="{$tel}" onChange="controlInfo()">
                                  </div>
                                  <button type="submit" class="btn btn-success " name="maj"><strong>Mise à jour</strong></button>
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

        //affiche le message d'alerte
        {$toggleScript}
    });

    </script>
Footer
);
echo $p->toHTML();

}
else if($user instanceof Administrateur){
  header("Location: pageAdmin.php");
}
