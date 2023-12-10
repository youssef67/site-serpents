<?php
//session_start();
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$data = [];

if ($_GET["idFemelle"] !== "null") {
    $femelle = $a->selectById($_GET["idFemelle"]);

    if (!empty($femelle)) {
        $data["nomFemelle"] = $femelle[0]['nom'];
        $data["idFemelle"] = $femelle[0]['id_animal'];
        $data["photoFemelle"] = $femelle[0]['path_img'];
    }
}


if ($_GET["idMale"] !== "null") {
    $male = $a->selectById($_GET["idMale"]);

    if (!empty($male)) {
        $data["nomMale"] = $male[0]['nom'];
        $data["idMale"] = $male[0]['id_animal'];
        $data["photoMale"] = $male[0]['path_img'];
    }
}


echo json_encode($data);
