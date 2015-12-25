<?php
require_once "class/entrepreneur.class.php";
require_once "autoload.inc.php";
require_once "init.inc.php";

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


if($user instanceof Entrepreneur ) {

	$entrepreneurValide = false;
	$entreprises = $user->getEntreprises();
	foreach ($entreprises as $key => $entreprise) {
		if($entreprise->getId() == $_REQUEST['id'])
			$entrepreneurValide = true;
	}
	if($entrepreneurValide){
		/*
		foreach ($entreprise->getStages() as $key => $value) {
	        $id= htmlspecialchars( $value->getId() );
	        $nom = htmlspecialchars( $value->getNom() );
	        $listEntreprises .= "<a href='entreprise.php?id={$id}' class='list-group-item'>{$nom}</a>";
		}*/

	    $p->appendContent(<<<HTML
	    <div class="container">
			<div class="panel panel-default"> <!-- Création Stage -->
			  <div class="panel-heading"><strong>Crée un Stages</strong></div>
			  <div class="panel-body">
				  <form>
				  	<label for="titre">Intitulé du poste</label>
				  	<input name="titre" type="text" class="form-control" placeholder="Tritre du stage" required>

				  	<label for="description">Description du stage</label>
				  	<textarea name="description" class="form-control" rows="15" placeholder="Description du stage ..."></textarea>

				  	<label for="titre">Gratification</label>
				  	<input name="gratification" type="text" class="form-control" >

				  	<div class="row" > <!--row -->
				  		<div class="col-lg-4">
				  			<label for="dateDebut">Date du début du stage</label>
				  			<input name="dateDebut" type="date" class="form-control" placeholder="JJ/MM/AAAA" required>
				  		</div>
				  		<div class="col-lg-4">
				  			<label for="dateFin">Date de fin du stage</label>
				  			<input name="dateFin" type="date" class="form-control" placeholder="JJ/MM/AAAA" required>
				  		</div>
				  		<div class="col-lg-4">
				  			<label for="nbPostes">Nombre de stagiaire</label>
				  			<input class="form-control" type="number" min="1" step="1" value="1" name="nbPostes" required>
				  		</div>
				  	</div>
				  	<div class="row" style="text-align:center;margin-top:8px"> <!--row -->
				  		<button type="submit" class="btn btn-success btn-lg"><strong>Crée le stage</strong></button>
				  	</div>
				  </form>
			  </div>
			</div> <!-- End création stage -->


			<div class="panel panel-default"> <!-- Stages block -->
			  <div class="red panel-heading"><strong>Stages</strong></div>
			  <div class="panel-body">

				<div class="row"> <!--row -->
			        <form class="form-inline">
					  <div class="col-lg-6">
					  	<div class="form-group">
					  		<label for="stage" style="color:#000">Selectionnez un stage: </label>
			                <select name="stage"type="text" class="form-control" aria-label="..." required>
			                    <option value="#">Selectionnez un stage</option>
			                </select>
			            </div>
					  </div><!-- /.col-lg-6 -->

					  <div class="col-lg-6">
						    <div class="input-group">
							    <button name="modifier" type="submit" class="btn btn-default "><strong>Modifier</strong></button>
							    <button name="supprimer" type="submit" class="btn btn-default "><strong>Supprimer</strong></button>
							    <button name="Aperçu" type="submit" class="btn btn-default "><strong>Aperçu</strong></button>
						    </div><!-- /input-group -->
					  </div><!-- /.col-lg-6 -->

				   	</form>
				</div><!-- /.row -->

			  </div>
			</div> <!--end Stage block -->			
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
}

