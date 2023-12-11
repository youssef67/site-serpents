<?php
require("../classes/Bdd.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$query = "SELECT * FROM Animal WHERE genre = " . $_GET['genre']  ." AND id_animal = " . $_GET['id'] . " AND delete_at IS NULL";

$serpent = $connAjax->execRequest($query);

if (empty($serpent))
    echo "notOk";
