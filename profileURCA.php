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

$p->appendContent(<<<HTML
    <div class="container">
        <p>Bonjour {$user->getID()} !</p>
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
