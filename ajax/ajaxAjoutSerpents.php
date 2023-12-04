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

$nbOfSnakesToCreate = intval($_POST["nbSnakes"]);

for ($i = 0; $i < $nbOfSnakesToCreate; $i++) {

    $s = new \classes\Animal("new");

    $nameRandomIndex = rand(0, count($arr_names) - 1);
    $raceRandomIndex = rand(0, count($arr_race_int) - 1);
    $genderRandomIndex = rand(0, count($arr_gender_int) - 1);

    //Créer un tableau avec les noms des fichiers d'images
    $dir = "../img/snake-img";
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

    $s->set("nom", $arr_names[$nameRandomIndex]);
    $s->set("id_race", $arr_race_int[$raceRandomIndex]);
    $s->set("genre", $arr_gender_int[$genderRandomIndex]);
    $s->set("poids", rand(0, 20000));
    $s->set("duree_vie", rand(0, 960));


    //Création d'une date de début en chaine de caractère
    $dateStart = new DateTime("NOW");
    $dateStartToString = $dateStart->format("Y-m-d");

    //Création d'une date de fin en chaine de caractère
    $dateEnd = $dateStart->modify('+3 day');
    $dateEndToString = $dateEnd->format("Y-m-d");

    //Generation d'un timeStamp aléatoire
    $randomTimeStamp = rand(strtotime($dateStartToString), strtotime($dateEndToString));
    $randomDate = date('Y-m-d', $randomTimeStamp);
    //Generation d'une date aleatoire

    $s->set("date_naissance", $randomDate);
}

$_SESSION["currentPage"] = 1;
$parPage = 5;

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

$animals = $a->selectAll($premier, $parPage);

$pages =  ceil($a->selectCountAll() / $parPage);

if (count($animals) > 0) {
    require "../components/tableSnakeHead.php";

    foreach ($animals as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "../components/tableSnakeContent.php";
    }

    require "../components/tableSnakeEnd.php";
    require "../components/pagination.php";
}
else {
    echo "<div class='row mt-5 text-center'>
        <div class='alert alert-danger col-md-6 offset-md-3' role='alert'>
        Pas de résultat pour cette recherche
        </div>
    </div>";
}

