<?php
include_once "autoload.inc.php";
include "myPDO.include.php";
include "class/entrepreneur.class.php";

try{
	$entrepreneur = Entrepreneur::createFromAuthSHA1($_REQUEST);
	$entrepreneur->saveIntoSession();
	var_dump($entrepreneur);
	//header("Location: index.php");
	exit;
}catch(Exception $e){
	echo 'Caught exception: ',  $e->getMessage(), "\n";
	header("Location: index.php?err=log");
}
