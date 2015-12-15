<?php

include_once "myPDO.include.php";

$mail = $_REQUEST['mail'];
$pass = $_REQUEST['pass'];
$pdo = myPDO::getInstance();
