<?php
session_start();

$idSerpent = $_GET["id"];
$genreSerpent = $_GET["genre"];

if (intval($genreSerpent) === 1) {
    $_SESSION["femelle_selected"] = $idSerpent;
    $_SESSION["male_selected"] = "";
 } else {
    $_SESSION["male_selected"] = $idSerpent;
    $_SESSION["femelle_selected"] = "";
}
