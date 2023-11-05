<?php
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");



$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

// Récupération des races disponibles + id correspondant
$races = $connAjax->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

// Création d'un tableau des valeurs passées dans le filtre
$arr = [];

// Vérification que les valueurs ne sont pas vides et si pas vide, ajout dans le tableau
$name = (isset($_POST["nom"]) && !empty($_POST["nom"])) ? $arr["nom"] = htmlspecialchars(trim($_POST["nom"])) : "";
$race = (isset($_POST["id_race"]) && $_POST["id_race"] != "Rechercher par race") ? $arr["id_race"] =  htmlspecialchars(trim($_POST["id_race"])) : "";
$genre = (isset($_POST["genre"]) && $_POST["genre"] != "Rechercher par genre") ? $arr["genre"] =  htmlspecialchars(trim($_POST["genre"])) : "";

if (!empty($name) || !empty($race) || !empty($genre)) {
// Si valeurs passées dans le formulaire alors traitement

    // Récupére les clés et le valeurs pour créer une requête SQL dynamique
    $keys = array_keys($arr);
    $values = array_values($arr);

    // Création de la requête WHERE en fonction du nombre de valeurs présentent dans le tableau
    $conditions = [];
    for($i = 0; $i < count($keys); $i++) {
        if ($keys[$i] == "nom")
            $conditions[] = '`' . $keys[$i] . '` = "' . $values[$i] . '"';
        else
            $conditions[] = '`' . $keys[$i] . '` = ' . $values[$i];

        if($i != count($keys) - 1)
            $conditions[$i] .= " AND ";
    }

    //Séparation du tableau des conditions en chaine de caractères
    $whereValues = implode(" ", $conditions);

    //Concaténation de la chaine avec la requete SQL
    $request = 'SELECT * FROM Animal WHERE ' . $whereValues;

    $animals = $connAjax->execRequest($request);

    if (count($animals) > 0) {

        echo "<table class='table align-middle mb-0 bg-white card-body p-5 text-center'>
            <thead class='bg-light'>
                <tr>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Genre</th>
                    <th>Poids</th>
                    <th>Durée de vie</th>
                    <th>Date de naissance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($animals as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        echo "<tr>
                <td>
                    <div class='d-flex align-items-center'>
                        <img src='../img/snake-img/" . $animal["path_img"] . "'" .
                            "class='rounded-circle'
                            alt=''
                            style='width: 55px; height: 55px'
                        />
                        <div class='ms-3'>"
                        . $animal["nom"] .
                        "</div>
                    </div>
                </td>
                <td>" .
                \classes\Race::getRace($animal["id_race"]) .
                "</td>
                <td>" .
                    $sexe .
                "</td>
                <td>" .
                    $poids .
                "</td>
                <td>" .
                    $a->convertDureeVieEnString($animal["duree_vie"]) .
                "</td>
                <td>" .
                    $a->convertDateNaissanceToDateTime($animal["date_naissance"]) .
                "</td>
                <td>
                    <a type='button' class='btn btn-warning' href='../index.php?page=updtSnake&id=" . $animal["id_animal"] . "'>Modifier</a>
                    <a type='button' class='btn btn-danger' href='../index.php?page=deleteSnake&id=" . $animal["id_animal"] . "'>Modifier</a>
                </td>
            </tr> 
        </tbody>
    </table>";
    }
    } else {
        echo "<div class='row mt-5 text-center'>
            <div class='alert alert-danger col-md-6 offset-md-3' role='alert'>
            Pas de résultat pour cette recherche
            </div>
        </div>";
    }
}