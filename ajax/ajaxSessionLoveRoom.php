<?php
//session_start();
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$IdfemelleBackUp = $connAjax->execRequest("SELECT id_animal FROM Animal WHERE genre = 2 AND delete_at IS NULL LIMIT 1 ");
$idMaleBackUp = $connAjax->execRequest("SELECT id_animal FROM Animal WHERE genre = 1 AND delete_at IS NULL LIMIT 1 ");

$idFemelle = $_GET["idFemelle"] === "null" ? $IdfemelleBackUp[0]["id_animal"] : $_GET["idFemelle"];
$idMale = $_GET["idMale"] === "null" ? $idMaleBackUp[0]["id_animal"] : $_GET["idMale"];


$femelle = $a->selectById($idFemelle);
$male = $a->selectById($idMale);

$data = [
    "nomFemelle" => $femelle[0]['nom'],
    "idFemelle" => $femelle[0]['id_animal'],
    "photoFemelle" => $femelle[0]['path_img'],
    "nomMale" => $male[0]['nom'],
    "idMale" => $male[0]['id_animal'],
    "photoMale" => $male[0]['path_img']
];

//$_SESSION["femelleSelectionne"] = $idFemelle;
//$_SESSION["maleSelectionne"] = $idMale;

echo json_encode($data);
