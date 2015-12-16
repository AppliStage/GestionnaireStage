<?php
include_once "autoload.inc.php";

try{
	$entrepreneur = createFromAuthSHA1($_REQUEST);
	$entrepreneur->saveIntoSession();
	header("Location: index.php")
	exit;
}catch(Exception $e){
	header("Location: index.php?err=log");
	exit;
}
