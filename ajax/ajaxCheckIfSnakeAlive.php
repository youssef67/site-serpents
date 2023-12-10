<?php
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

//Mise à jour de la BDD avec modification du champs delete_at pour les serpent qui ont une date de décès supérieur
//au moment de l'exécution du script
$query = "SELECT * FROM Animal WHERE id_animal = " . $_GET['id'] . " AND `date_mort` <= NOW()";
$connAjax->execRequest($query);
