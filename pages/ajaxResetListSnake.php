<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

//Si requete SQL sauvegardée, suppresion de la variable en session
unset($_SESSION["save_request"]);

// Récupération des races disponibles + id correspondant
$races = $connAjax->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

$request = 'SELECT * FROM Animal WHERE delete_at IS NULL ORDER BY `nom` DESC LIMIT 0, 5';

$animals = $connAjax->execRequest($request);

if (count($animals) > 0) {
    require "../components/tableSnakeHead.php";

    foreach ($animals as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "../components/tableSnakeContent.php";
    }

    require "../components/tableSnakeEnd.php";
} else {
    echo "<div class='row mt-5 text-center'>
        <div class='alert alert-danger col-md-6 offset-md-3' role='alert'>
        Pas de résultat pour cette recherche
        </div>
    </div>";
}
