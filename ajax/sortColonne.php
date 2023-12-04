<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

// Création du sorting de façon dynamique
$sort = " ORDER BY " . $_GET["field"] . ' '  .$_GET["typeSort"];

//Nombre de serpents par page
$parPage = 5;
// Calul de la première occurence à prendre
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;
//$arrId = explode(",", $_GET["id"]);

// ON vérifie si le sort se fait alors qu'une recherche par filtre est en cours
if (isset($_SESSION["save_request"])) {
    $request = $_SESSION["save_request"] . $sort . ' LIMIT 0, 5';
    //$requestId = 'SELECT id_animal FROM Animal WHERE `id_race` = 1 AND id_animal IN (' .  implode(',', $arrId) .  ')' . $sort . ' LIMIT 0, 5';
}
 else {
     $request = "SELECT * FROM Animal" . $sort . " LIMIT 0, 5";
     //$requestId = "SELECT id_animal FROM Animal WHERE id_animal IN (" .  implode(',', $arrId) .  ") " . $sort . ' LIMIT 0, 5';
 }

 //Si sort suite à un filtre ou pas
if (isset($_SESSION["nb_resultat_filtre"]))
    $pages = ceil($_SESSION["nb_resultat_filtre"] / $parPage);
else
    $pages = ceil($a->selectCountAll() / $parPage);

//Récupération des ID lors du chargement de la page
//$animalsId = $connAjax->execRequest($requestId);
//$lstAnimalId = [];
//
//foreach ($animalsId as $animal) {
//    array_push($lstAnimalId, $animal["id_animal"]);
//}

$lstAnimal = $connAjax->execRequest($request);

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


