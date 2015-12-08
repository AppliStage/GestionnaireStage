<?php

require_once 'autoload.inc.php';

$p = new webpage("inscription");

$p->appendContent(<<<HTML

<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Adresse email</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
  </div>
  
  <div class="form-group">
    <label for="exampleInputPseudo1">Identifiant</label>
    <input type="text" class="form-control" id="exampleInputPseudo1" placeholder="Pseudo">
  </div>
    
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  
  <div class="checkbox">
    <label>
      <input type="checkbox"> J'accepte les conditions d'utilisation
    </label>
  </div>
  <button type="submit" class="btn btn-default">Envoyer</button>
</form>

HTML
);

echo $p->ToHTML();