<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$arr_names = [
    "Skylar",
    "Flare",
    "Happy",
    "Nolan",
    "Toffee",
    "Bandicoot",
    "Syrup",
    "Fluff",
    "Snuggle",
    "Elmer",
    "Monte",
    "General",
    "Critter",
    "Cookie",
    "Wolf",
    "Chrono",
    "Wrigley",
    "Monte",
    "Ranger",
    "Tilly",
    "Pirate",
    "Nero",
    "Nimble",
    "Fuzzy"];

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

$arr_race_int = explode(",", $_POST["races_id"]);
$arr_gender_int = explode(",", $_POST["genders_id"]);

//var_dump($arr_gender_int);
//var_dump($arr_race_int);

$nbOfSnakesToCreate = intval($_POST["nbSnakes"]);

for ($i = 0; $i < $nbOfSnakesToCreate; $i++) {

    $s = new \classes\Animal("new");

    $nameRandomIndex = rand(0, count($arr_names) - 1);
    $raceRandomIndex = rand(0, count($arr_race_int) - 1);
    $genderRandomIndex = rand(0, count($arr_gender_int) - 1);

    //Créer un tableau avec les noms des fichiers d'images
        $dir = "img/snake-img";
        $fileList = [];

        if(is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        $fileList[] = $file;
                    }
                }
                closedir($dh);
            }
        } else {
            var_dump("le dossier n'existe pas !");
        }

        // Selection d'un nom de fichier dans le tableau + ajout en BDD
        $index = array_rand($fileList, 1);
        $s->set("path_img", $fileList[$index]);
    //duree vi maximal 960
    //poids maximal 20000

    var_dump($arr_names[$nameRandomIndex]);
    $s->set("nom", $arr_names[$nameRandomIndex]);
    $s->set("id_race", $arr_race_int[$raceRandomIndex]);
    $s->set("genre", $arr_gender_int[$genderRandomIndex]);
    $s->set("poids", rand(0, 20000));
    $s->set("duree_vie", rand(0, 960));
    $s->set("date_naissance", new DateTime());



}

