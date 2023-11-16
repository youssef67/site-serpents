<?php
session_start();
require_once("../classes/Bdd.php");
require_once("../classes/Race.php");
require_once("../classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

if (isset($_GET["confirmId"])) {
    $gender = $conn->select("Animal", $_GET["confirmId"], "genre");

    if (intval($gender)  === 1)
        $_SESSION["femelle_selected"] = $_GET["confirmId"];
    else
        $_SESSION["male_selected"] = $_GET["confirmId"];


    echo "c'est fait";

} else {
    $nomfemelle = $conn->select("Animal", $_GET["id"], "nom");
    $raceIdfemelle = $conn->select("Animal", $_GET["id"], "id_race");
    $req = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $raceIdfemelle . "'");

    $nomRace = $req[0]["nom_race"];

    if (intval($_GET["gender"]) === 1) {
        if(isset($_SESSION["femelle_selected"]) && $_SESSION["femelle_selected"] !== $_GET["id"]) {
            //Récupération de la femelle qui vient d'être selectionné en BDD
            $nomfemelle = $conn->select("Animal", $_GET["id"], "nom");
            $raceIdfemelle = $conn->select("Animal", $_GET["id"], "id_race");
            $req = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $raceIdfemelle . "'");
            $nomRace = $req[0]["nom_race"];

            //Récupération de la femelle eneregistré en Session
            $nomfemelleSession = $conn->select("Animal", $_SESSION["femelle_selected"], "nom");
            $raceIdfemelleSession = $conn->select("Animal", $_SESSION["femelle_selected"], "id_race");
            $reqSession = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $raceIdfemelleSession . "'");
            $nomRaceSession = $req[0]["nom_race"];

            $data = [
                "title_editSelectSnake" => "Sélection femelle",
                "alreadySelected_name" => $nomfemelleSession,
                "alreadtySelected_race" => $nomRaceSession,
                "newSelected_name" => $nomfemelle,
                "newSelected_race" => $nomRace,
                "id" => $_GET["id"]
                ];

            header('Content-Type: application/json');
            echo json_encode($data);

        } else {
            $nomfemelle = $conn->select("Animal", $_GET["id"], "nom");
            $raceIdfemelle = $conn->select("Animal", $_GET["id"], "id_race");
            $req = $conn->execRequest("SELECT `nom_race` FROM Race WHERE `id_race` = '" . $raceIdfemelle . "'");
            $nomRace = $req[0]["nom_race"];

            $_SESSION["femelle_selected"] = $_GET["id"];

            $data = ["nomFemelle" => $nomfemelle, "nomRace" => $nomRace];
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    } else {
        if(isset($_SESSION["male_selected"]) && $_SESSION["male_selected"] === $_GET["id"]) {
            echo "3";

        } else {
            echo "4";
            $_SESSION["male_selected"] = $_GET["id"];
        }
    }

}

