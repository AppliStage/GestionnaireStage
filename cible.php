<?php

include_once "myPDO.include.php";

$mail = $_POST['mail'];
$pass = $_POST['pass'];
$pdo = myPDO::getInstance();

$rq1 = $pdo->prepare(<<<SQL
SELECT nom, prenom, mail, adresse, tel, fonction
FROM Entrepreneur
WHERE mail = ?
SQL
);

$rq1->execute(array($mail));
$rq1->setFetchMode(PDO::FETCH_CLASS, "Entrepreneur");
$res = $rq1->fetch();
var_dump($rq1);
var_dump($res);

if(!$res){
  $res->startSession();
  $res->saveIntoSession();
  header("Location: index.php");
}
else{
  header("Location: index.php?err=0");
}

