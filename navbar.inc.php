<?php

/********************************************
 * BAR DE NAVIGATION                        *
 ********************************************/

$pageCourrante =  $_SERVER['REQUEST_URI']; 

if (!Utilisateur::isConnected()){
  $form = Utilisateur::loginFormSHA1("cible.php");
  $profile = "";
}
else{
  $form = <<<HTML
      <ul class="nav navbar-nav navbar-right">
        <li>
          <form method="POST" action="{$pageCourrante}?logout=true" name="connexion" class="form-inline" style="padding-top:8px">
           <button type="submit" class="btn btn-default" name="logout">Déconnexion</button>
          </form>
        </li>
      </ul>
HTML;
  $profile = "<li><a href='profile.php'>Profile</a></li>";
}

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
            {$profile}
          </ul>
          {$form}
        </div><!--/.nav-collapse -->
      </div>
    </nav>
HTML
);

if (isset($_REQUEST['logout'])) { 
  Utilisateur::logoutIfRequested();
  header("Location: index.php");
  exit;
}