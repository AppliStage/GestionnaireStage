<?php
include_once "class/utilisateur.class.php";

if(isset($_POST['logout'])){
	Utilisateur::logoutIfRequested();
}
header("Location: index.php");
