<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

// Récupération des races disponibles + id correspondant
$races = $connAjax->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

//Nombre de serpents par page
$parPage = 5;
$_SESSION["currentPage"] = 1;

// Reset de l'ensemble des variable permettant de sauvegarder la requete généré par les filtres
unset($_SESSION["nb_resultat_filtre"]);
unset($_SESSION["pages"]);
unset($_SESSION["save_request"]);

$page = 1;
$pages =  ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
$animals = $a->selectAll($premier, $parPage);

if (count($animals) > 0) {
    require "../components/tableSnakeHead.php";

    foreach ($animals as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "../components/tableSnakeContent.php";
    }

    require "../components/tableSnakeEnd.php";
    require "../components/pagination.php";
} else {
    echo "<div class='row mt-5 text-center'>
    <div class='alert alert-danger col-md-6 offset-md-3' role='alert'>
    Pas de résultat pour cette recherche
    </div>
</div>";
}

