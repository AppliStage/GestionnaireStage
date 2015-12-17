<?php
include_once 'class/entrepreneur.class.php';

if(isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['mail']) && isset($_GET['pass']) &&isset($_GET['tel'])){  
	Entrepreneur::inscription($_GET['nom'],$_GET['prenom'],$_GET['mail'],$_GET['pass'],$_GET['tel']);
}
