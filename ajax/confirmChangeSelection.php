<?php
session_start();
require_once("../classes/Bdd.php");
require_once("../classes/Race.php");
require_once("../classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

// On recupére en BDD, les infos du serpent selectionné
$nom = $conn->select("Animal", $_GET["id"], "nom");
$race = $conn->select("Animal", $_GET["id"], "id_race");
$req = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $race . "'");
$nomRace = $req[0]["nom_race"];

//Récupération du serpent enregistré en Session
$nomSession = $conn->select("Animal", $_GET["idSession"], "nom");
$raceIdSession = $conn->select("Animal", $_GET["idSession"], "id_race");
$reqSession = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $raceIdSession . "'");
$nomRaceSession = $reqSession[0]["nom_race"];

$data = [
    "title_editSelectSnake" => intval($_GET["gender"]) === 1 ? "Selection femelle" : "Sélection male",
    "nameSession" => $nomSession,
    "raceSession" => $nomRaceSession,
    "nameSelected" => $nom,
    "raceSelected" => $nomRace,
    "id" => $_GET["id"],
    "genre" => intval($_GET["gender"]) === 1 ? 1 : 2
    ];

echo json_encode($data);


