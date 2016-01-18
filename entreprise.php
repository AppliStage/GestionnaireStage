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
$p->appendJs(<<<JS
  function controlDate(){
    res = false;
    
    dateDeb = document.getElementById('dateDeb').value;
    dateFin = document.getElementById('dateFin').value;
    
    formatDateDeb = dateDeb.match(/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/);
    formatDateFin = dateFin.match(/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/);
    statutDateFin = false;
    statutDateDeb = false;
    
    if(formatDateDeb != null && formatDateFin != null){
      temp = dateDeb.split('/');
      anDateDeb = temp[2];
      jDateDeb= temp[0];
      mDateDeb= temp[1];
      temp = dateFin.split('/');
      anDateFin = temp[2];
      jDateFin = temp[0];
      mDateFin = temp[1];
      
      if(anDateDeb <= anDateFin){
	if(mDateDeb <= mDateFin){
	  if(jDateDeb <= jDateFin){
	    statutDateDeb = true;
	    statutDateFin = true;
	    res = true;
	    if(mDateDeb == '02'){
	      if(jDateDeb == '29'){
		if(!((anDateDeb%400 == 0) && (anDateDeb%100 == 0))){
		  statutDateDeb = false;
		  res = false;
		}
	      }
	    }
	    if(mDateFin == '02'){
	      if(jDateFin == '29'){
		if(!((anDateFin%400 == 0) && (anDateFin%100 == 0))){
		  statutDateFin = false;
		  res = false;
		}
	      }
	    }
	  }
	}
      }
    }
    
        
    if(!statutDateDeb){
      document.getElementById('formDateDeb').classList.add('has-error');
      if(document.getElementById('formDateDeb').classList.contains('has-success')){
	document.getElementById('formDateDeb').classList.remove('has-success');
      }
    }else{
      document.getElementById('formDateDeb').classList.add('has-success');
      if(document.getElementById('formDateDeb').classList.contains('has-error')){
	document.getElementById('formDateDeb').classList.remove('has-error');
      }
    }
    
    if(!statutDateFin){
      document.getElementById('formDateFin').classList.add('has-error');
      if(document.getElementById('formDateFin').classList.contains('has-success')){
	document.getElementById('formDateFin').classList.remove('has-success');
      }
    }else{
      document.getElementById('formDateFin').classList.add('has-success');
      if(document.getElementById('formDateFin').classList.contains('has-error')){
	document.getElementById('formDateFin').classList.remove('has-error');
      }
    }
    if(res){
      document.getElementById('dateDeb').value = anDateDeb + "-" + mDateDeb + "-" + jDateDeb;
      document.getElementById('dateFin').value = anDateFin + "-" + mDateFin + "-" + jDateFin;
    }
    return res;
  }


JS
);

//inclusion de la barre de navigation
include_once "navbar.inc.php";


if(($user instanceof Entrepreneur ) && isset($_REQUEST['id'])){

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
				  <form method="POST" action="creeStage.php"  onSubmit="return controlDate();">
				  	<label for="titre">Intitulé du poste</label>
				  	<input name="titre" type="text" class="form-control" placeholder="Tritre du stage" required>

				  	<label for="description">Description du stage</label>
				  	<textarea name="description" class="form-control" rows="15" placeholder="Description du stage ..."></textarea>

				  	<div class="row" > <!--row -->
				  		<div class="col-lg-6">
						  	<label for="titre">Gratification</label>
						  	<input name="gratification" type="text" class="form-control" >
				  		</div>
				  		<div class="col-lg-6">
						  	<label for="domaine">Domaine</label>
			                <select name="domaine" class="form-control" aria-label="..." required>
			                    <option value="informatique">informatique</option>
			                    <option value="gestion">Gestion</option>
			                    <option value="Droit">Droit</option>
			                </select>
				  		</div>
				  	</div><!-- end row -->

				  	<div class="row" > <!--row -->
				  		<div class="col-lg-4" id="formDateDeb">
				  			<label for="dateDebut">Date du début du stage</label>
				  			<input name="dateDebut" id="dateDeb" type="date" class="form-control" placeholder="JJ/MM/AAAA" required>
				  		</div>
				  		<div class="col-lg-4" id="formDateFin">
				  			<label for="dateFin">Date de fin du stage</label>
				  			<input name="dateFin" id="dateFin" type="date" class="form-control" placeholder="JJ/MM/AAAA" required>
				  		</div>
				  		<div class="col-lg-4">
				  			<label for="nbPostes">Nombre de stagiaire</label>
				  			<input class="form-control" type="number" min="1" step="1" value="1" name="nbPostes" required>
				  		</div>
				  	</div>
				  	<div class="row" style="text-align:center;margin-top:8px"> <!--row -->
				  		<input type='hidden' name='id' value={$_GET['id']}>
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
			                <select name="stage" class="form-control" aria-label="..." required>
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

