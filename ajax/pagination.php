<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

//Nombre de serpents par page
$parPage = 5;

if (isset($_SESSION["nb_resultat_filtre"]))
    $pages = ceil($_SESSION["nb_resultat_filtre"] / $parPage);
else
    $pages = ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_GET["nextPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
if (isset($_SESSION["nb_resultat_filtre"])) {
    $request = $_SESSION["save_request"] . ' AND delete_at IS NULL LIMIT ' . $premier . ', ' . $parPage;

    $animalsId = $conn->execRequest("SELECT id_animal FROM Animal WHERE `id_race` = 1 AND delete_at IS NULL LIMIT 5, 5");

    $lstAnimalId = [];

    foreach ($animalsId as $animal) {
        array_push($lstAnimalId, $animal["id_animal"]);
    }

    $lstAnimal = $conn->execRequest($request);
}
else {
    $lstAnimal = $a->selectAll($premier, $parPage);
    $lstAnimalId = $a->selectOnlyIdAll($premier, $parPage);
}

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
