<?php
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$totalSerpents = $a->selectCountAll();
$nbFemelles = $a->selectAllCountByGender("genre", 1);
$nbMale = $a->selectAllCountByGender("genre", 2);

$data = [
    "totalSerpents" => $totalSerpents,
    "nbFemelles" => $nbFemelles,
    "nbMales" => $nbMale
];

echo json_encode($data);