<?php
include_once 'autoload.inc.php';
include_once 'init.inc.php';

$p = new webpage("Administration");
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
$p->appendCssUrl("style/searchEngine.css");
$p->appendJsUrl("js/request.js");

//inclusion de la barre de navigation
include_once "navbar.inc.php";

$p->appendContent(<<<HTML
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Panel heading</div>

  <!-- Table -->
  <table class="table">
  <tr><th scope="col">N°</th><th scope="col">Numéro convention</th><th scope="col">Entreprise</th><th scope="col">Enseignant réferent</th></tr>
HTML
);
require_once 'myPDO.include.php';

$db = myPDO::getInstance();
$stmt = $db -> prepare(<<<SQL
			  SELECT c.numConvention, e.nom, c.loginEnseignant
			  FROM Convention c, Stage s, Entreprise e
			  WHERE c.numStage = s.numStage AND s.numEntreprise = e.numEntreprise
			  ORDER BY 1;
SQL
);
$stmt -> setFetchMode(PDO::FETCH_CLASS, __CLASS__);
$stmt -> execute();
$res = null;
$i=1;
while(($res[] = $stmt->fetch())!== false){
  $p->appendContent(<<<HTML
<tr><th scope="row">$i</th><td>$res[0]</td><td>$res[1]</td><td>$res[2]</td></tr>
HTML
);
$i++;
}
$p->appendContent(<<<HTML
</table>
</div>
HTML
);

echo $p->toHTML();