<?php
require_once("classes/Bdd.php");
require_once("classes/Race.php");
require_once("classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");
$arr_race = [];

foreach ($races as $race) {
    $arr_race[$race["id_race"]] = $race["nom_race"];
}



