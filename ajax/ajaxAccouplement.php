<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

// Suppresion des entrées crée avec la création d'un serpent
$a->deleteEntriesNull();

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
    "Fuzzy",
    "Zion",
    "Snooze",
    "Rubiks",
    "Hoagie",
    "Raz",
    "Gonzo",
    'Twist',
    'Fuzzy',
    'Treat',
    'Tundra',
    'Kent',
    'Riley',
    "Hades",
    "Remington",
    "Gambit",
    "Voltron",
    "Baloo",
    "Frenzy",
    'Splash',
    'Nimbus',
    'Hilton',
    'Rumi',
    'Bogey',
    'Vango',
    "Lurch",
    "Mo",
    "Dusk",
    "Mickey",
    "Sonata",
    "Abyss",
    "Cluster",
    "Mars",
    "Herald",
    "Wink",
    "Rasputin",
    "Kicker",
];

//Récupération des informations de la mère
$mere = $a->selectById($_GET["idFemelle"]);
//Récupération des information du père
$pere = $a->selectById($_GET["idMale"]);

//Créer un tableau avec les deux races du père et de la mère
$racesParent = [$mere[0]["id_race"], $pere[0]["id_race"]];

// Création d'un nouveau serpent
$s = new \classes\Animal("new");

//Choix des randoms pour les champs Nom / Race / Gendre
$nameRandomIndex = rand(0, count($arr_names) - 1);
$raceRandomIndex = rand(0, 1);
$genderRandom = rand(1, 2);

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

//Alimentation des champs de la BDD
$s->set("nom", $arr_names[$nameRandomIndex]);
$s->set("id_race", $racesParent[$raceRandomIndex]);
$s->set("genre", $genderRandom);
$s->set("poids", rand(0, 20000));
$s->set("duree_vie", rand(0, 960));
// Selection d'un nom de fichier dans le tableau + ajout en BDD
$index = array_rand($fileList, 1);
$s->set("path_img", $fileList[$index]);

$s->set("id_mere", $_GET["idFemelle"]);
$s->set("id_pere", $_GET["idMale"]);

//Création d'une date de naissance
$date = new DateTime("NOW");
$dateToString = $date->format("Y-m-d");

$s->set("date_naissance", $dateToString);

$data = [
    "nomEnfant" => $arr_names[$nameRandomIndex],
];

echo json_encode($data);









