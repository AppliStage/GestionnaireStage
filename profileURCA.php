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

if($user instanceof Etudiant){

	if(isset($_POST['maj']) and isset($_POST['nomEtudiant']) and isset($_POST['prenomEtudiant']) and isset($_POST['mailEtudiant']) and isset($_POST['telEtudiant'])){
		
		$nomM= htmlspecialchars($_POST['nomEtudiant']);
    		$prenomM = htmlspecialchars($_POST['prenomEtudiant']);
   		$mailM = htmlspecialchars($_POST['mailEtudiant']);
		$telM = htmlspecialchars($_POST['telEtudiant']);
		$user->update($user->getId(),$nomM,$prenomM,$mailM,$telM);
	}

 
    $nom= htmlspecialchars( $user->getNom() );
    $prenom = htmlspecialchars( $user->getPrenom() );
    $mail = htmlspecialchars( $user->getMail() );
    $tel = htmlspecialchars( $user->getTel() );

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
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
                                <form  method="POST" action="#">
                                  <div class="form-group">
                                    <label for="nomEtudiant">Nom</label>
                                    <input type="text" class="form-control" name="nomEtudiant" pattern="[a-zA-Z].+" placeholder="{$nom}" value="{$nom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="prenomEtudiant">Prenom</label>
                                    <input type="text" class="form-control" name="prenomEtudiant" pattern="[a-zA-Z].+" placeholder="{$prenom}" value="{$prenom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="mailEtudiant">Email</label>
                                    <input type="email" class="form-control" name="mailEtudiant" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="{$mail}" value="{$mail}">
                                  </div>
                                  <div class="form-group">
                                    <label for="telEtudiant">Telephone</label>
                                    <input type="text" class="form-control" name="telEtudiant" placeholder="{$tel}" value="{$tel}">
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
    });
    </script>
Footer
);
echo $p->toHTML();

//<<<<<<< HEAD
}
//=======
//}
//elseif($user instanceof Administrateur){
/*
$p->appendContent(<<<HTML
    <div class="container">
        <p>Bonjour {$user->getID()} !</p>
    </div>
HTML
);

 
    $nom= htmlspecialchars( $user->getNom() );
    $prenom = htmlspecialchars( $user->getPrenom() );
    $mail = htmlspecialchars( $user->getMail() );
    $fonction = htmlspecialchars( $user->getFonction() );
    $tel = htmlspecialchars( $user->getTel() );

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
                <div class="col-md-3">
                    <div class="list-group">
                      <button type="button" data-toggle="tab" data-target="#profile" data-target="#1profile" class="list-group-item"><strong>Profile</strong></button>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="profile">
                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Profile</strong></h3>
                              </div>
                              <div class="panel-body">
                                <form>
                                  <div class="form-group">
                                    <label for="nomEtudiant">Nom</label>
                                    <input type="text" class="form-control" name="nomEtudiant" pattern="[a-zA-Z].+" placeholder="{$nom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="prenomEtudiant">Prenom</label>
                                    <input type="text" class="form-control" name="prenomEtudiant" pattern="[a-zA-Z].+" placeholder="{$prenom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="mailEtudiant">Email</label>
                                    <input type="email" class="form-control" name="mailEtudiant" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="{$mail}">
                                  </div>
                                  <div class="form-group">
                                    <label for="telEtudiant">Telephone</label>
                                    <input type="text" class="form-control" name="telEtudiant" placeholder="{$tel}">
                                  </div>
                                  <button type="submit" class="btn btn-success "><strong>Mise à jour</strong></button>
                                </form>
                              </div>
                            </div>

                            <div class="panel panel-default">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Changer le mot de passe</strong></h3>
                              </div>
                              <div class="panel-body">
                                <form>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Ancien mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputEmail1" >
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputEmail1" >
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" name="exampleInputPassword1" >
                                  </div>
                                  <button type="submit" class="btn btn-success "><strong>Mettre à jour le mot de passe</strong></button>
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
    });
    </script>
Footer
);
echo $p->toHTML();
*/
//}
//>>>>>>> 8f64b8c7094e35538ba8f202e40e4bf67ad2831f
//
elseif($user instanceof Enseignant){
 
	if(isset($_POST['maj']) and isset($_POST['nomEnseignant']) and isset($_POST['prenomEnseignant']) and isset($_POST['mailEnseignant']) and isset($_POST['telEnseignant'])){
		
		$nomM= htmlspecialchars($_POST['nomEnseignant']);
    		$prenomM = htmlspecialchars($_POST['prenomEnseignant']);
   		$mailM = htmlspecialchars($_POST['mailEnseignant']);
		$telM = htmlspecialchars($_POST['telEnseignant']);
		$user->update($user->getId(),$nomM,$prenomM,$mailM,$telM);
	}

 
    $nom= htmlspecialchars( $user->getNom() );
    $prenom = htmlspecialchars( $user->getPrenom() );
    $mail = htmlspecialchars( $user->getMail() );
    $tel = htmlspecialchars( $user->getTel() );

    $p->appendContent(<<<HTML
        <div class="container">
            <div class="row"> <!-- ROW  -->
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
                                <form  method="POST" action="#">
                                  <div class="form-group">
                                    <label for="nomEnseignant">Nom</label>
                                    <input type="text" class="form-control" name="nomEnseignant" pattern="[a-zA-Z].+" placeholder="{$nom}" value="{$nom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="prenomEnseignant">Prenom</label>
                                    <input type="text" class="form-control" name="prenoEnseignant" pattern="[a-zA-Z].+" placeholder="{$prenom}" value="{$prenom}">
                                  </div>
                                  <div class="form-group">
                                    <label for="mailEnseignant">Email</label>
                                    <input type="email" class="form-control" name="mailEnseignant" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="{$mail}" value="{$mail}">
                                  </div>
                                  <div class="form-group">
                                    <label for="telEnseignant">Telephone</label>
                                    <input type="text" class="form-control" name="telEnseignant" placeholder="{$tel}" value="{$tel}">
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
    });
    </script>
Footer
);
echo $p->toHTML();
}
