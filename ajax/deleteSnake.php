<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$connAjax->delete("Animal", $_GET["idSnake"]);

//Nombre de serpents par page
$parPage = 5;

// Calcul du nombre de pages nécessaires pour la pagination
$pages =  ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
$lstAnimal = $a->selectAll($premier, $parPage);

if (count($lstAnimal) > 0) {
    require "../components/tableSnakeHead.php";

    foreach ($lstAnimal as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "../components/tableSnakeContent.php";
    }

    require "../components/tableSnakeEnd.php";
    require "../components/pagination.php";
}
