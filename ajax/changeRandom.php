<?php
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

if(!empty($_GET['id']))
    $query = "SELECT * FROM Animal WHERE genre = " . $_GET['genre']  ." AND id_animal != " . $_GET['id'] . " AND delete_at IS NULL ORDER BY RAND() LIMIT 1";
else
    $query = "SELECT * FROM Animal WHERE genre = " . $_GET['genre']  ."  AND delete_at IS NULL ORDER BY RAND() LIMIT 1";

$serpent = $connAjax->execRequest($query);

if (!empty($serpent)) {
    $data = [
        "serpentNom" => $serpent[0]['nom'],
        "serpentPhoto" => $serpent[0]['path_img'],
        "genre" => $serpent[0]['genre'],
        "idSerpent" => $serpent[0]['id_animal']
    ];
} else
    $data = [];


echo json_encode($data);
