<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

//Nombre de serpents par page
$parPage = 5;

$pages = ceil($a->selectCountAllDeadSnake() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_GET["nextPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD

$lstAnimal = $a->selectAllDeadSnake($premier, $parPage);

$_SESSION["currentPage"] = $_GET["nextPage"];

if (count($lstAnimal) > 0) {
    echo "<table class='table align-middle mb-5 bg-white card-body p-5 text-center'>
            <thead class='bg-light'>
                <tr>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Genre</th>
                    <th>date de mort</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($lstAnimal as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        echo '<tr>
                <td>
                    <div class="d-flex align-items-center">
                    <img src="../img/snake-img/', $animal["path_img"], '" class="rounded-circle" alt="" style="width: 55px; height: 55px" />
                    <div class="ms-3">', $animal["nom"], '</div>
                    </div>
                </td>
                <td>', \classes\Race::getRace($animal["id_race"]), '</td>
                <td>', $sexe, '</td>
                 <td>', date("d-m-Y H:i:s", strtotime($animal["date_mort"])), '</td>
              </tr>';
    }

    require "../components/tableSnakeEnd.php";
    require "../components/pagination.php";
}
