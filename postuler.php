<?php

include_once 'autoload.inc.php';
include_once 'init.inc.php';

$p = new webpage("postuler");
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

include_once 'navbar.inc.php';

$p->appendContent("<p>Page vide MDRRRRR</p>");

echo $p->toHTML();