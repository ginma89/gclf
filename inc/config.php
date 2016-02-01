<?php
require 'fonctions.php';
// Connexion à la DB
$dsn = 'mysql:dbname=gcif;host=localhost;charset=UTF8';
$user = 'root';
$password = 'toor';

// Effectuer la connexion
$pdo = new PDO($dsn, $user, $password);

//INIT PAGE TITLE
$pageTitle='Mon titre de page';
?>