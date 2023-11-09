<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

//Nombre de serpents par page
$parPage = 5;

// Calcul du nombre de pages nécessaires pour la pagination
if (isset($_SESSION["currently_searching"]) && $_SESSION["currently_searching"])
    $pages = ceil($_SESSION["nb_resultat_filtre"] / $parPage);
else
    $pages = ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_GET["nextPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
if (isset($_SESSION["currently_searching"]) && $_SESSION["currently_searching"]) {
    $request = $_SESSION["save_request"] . ' AND delete_at IS NULL LIMIT ' . $premier . ', ' . $parPage;
    $lstAnimal = $conn->execRequest($request);
}
else
    $lstAnimal = $a->selectAll($premier, $parPage);

$_SESSION["currentPage"] = $_GET["nextPage"];

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
