<?php
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

//Mise à jour de la BDD avec modification du champs delete_at pour les serpent qui ont une date de décès supérieur
//au moment de l'exécution du script
$query = "SELECT id_animal FROM Animal WHERE id_animal = " . $_GET['id'] . " AND delete_at IS NULL";

$res = $connAjax->execRequest($query);

if(empty($res)) echo false;
else echo true;



