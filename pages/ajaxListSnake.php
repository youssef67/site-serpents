<?php
session_start();
require("../classes/Bdd.php");
require_once("../classes/Race.php");
require("../classes/Animal.php");

$connAjax = new \classes\Bdd();
$a = new \classes\Animal();

// Récupération des races disponibles + id correspondant
$races = $connAjax->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

// If concernant la recherche par filtre POST
if (isset($_POST["nom"]) || isset($_POST["id_race"]) || isset($_POST["genre"])) {
// Création d'un tableau des valeurs passées dans le filtre
    $arr = [];

// Vérification que les valeurs ne sont pas vides et si pas vide, ajout dans le tableau de travail
    $name = (isset($_POST["nom"]) && !empty($_POST["nom"])) ? $arr["nom"] = htmlspecialchars(trim($_POST["nom"])) : "";
    $race = (isset($_POST["id_race"]) && $_POST["id_race"] != "Rechercher par race") ? $arr["id_race"] = htmlspecialchars(trim($_POST["id_race"])) : "";
    $genre = (isset($_POST["genre"]) && $_POST["genre"] != "Rechercher par genre") ? $arr["genre"] = htmlspecialchars(trim($_POST["genre"])) : "";

    if (!empty($name) || !empty($race) || !empty($genre)) {
        // Si valeurs passées dans le formulaire alors traitement

        // Récupére les clés et le valeurs pour créer une requête SQL dynamique
        $keys = array_keys($arr);
        $values = array_values($arr);

        // Création de la requête WHERE en fonction du nombre de valeurs présentent dans le tableau
        $conditions = [];
        for ($i = 0; $i < count($keys); $i++) {
            if ($keys[$i] == "nom")
                $conditions[] = '`' . $keys[$i] . '` = "' . $values[$i] . '"';
            else
                $conditions[] = '`' . $keys[$i] . '` = ' . $values[$i];

            if ($i != count($keys) - 1)
                $conditions[$i] .= " AND ";
        }

        //Séparation du tableau des conditions en chaine de caractères
        $whereValues = implode(" ", $conditions);

        $_SESSION["currentPage"] = 1;
        //Informations concernant la pagination pour le résultat obtenu avec les filtres indiqués
        //Nombre de serpents par page
        $parPage = 5;

        // Calcul du nombre de pages nécessaires pour la pagination
        $requestCount = 'SELECT COUNT(*) as nb FROM Animal WHERE ' . $whereValues . ' AND delete_at IS NULL';
        $count = $connAjax->execRequest($requestCount);

        $pages =  ceil( $count[0]["nb"] / $parPage);
        $_SESSION["pages"] = $pages;

        //Calcul du 1er serpent de la liste
        //if(!isset($_SESSION["currentPageFilter"])) $_SESSION["currentPageFilter"] = 1;

        $premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

        //Concaténation de la chaine avec la requete SQL
        $request = 'SELECT * FROM Animal WHERE ' . $whereValues;

        $_SESSION["save_request"] =  $request;

        $request = 'SELECT * FROM Animal WHERE ' . $whereValues . ' AND delete_at IS NULL LIMIT ' . $premier . ', ' . $parPage;

        $_SESSION["save_request_to_truncate"] = $request;
        $_SESSION["premier_filter"] =  $premier;
        $_SESSION["parPage_filter"] =  $parPage;
    }
}

if (isset($_GET["field"]) && isset($_GET["typeSorting"])) {

        $pages = $_SESSION["pages"];

        $sort = " ORDER BY " . $_GET["field"] . ' '  .$_GET["typeSorting"];

        if(isset($_SESSION["save_request"])) {
            $requestTruncate = substr($_SESSION["save_request_to_truncate"], 8);
            $reqOnlyIdFromSaveRequest = "SELECT id_animal " . $requestTruncate;

            $arrIdAnimal = $connAjax->execRequest($reqOnlyIdFromSaveRequest);

            $arrayId = [];

            foreach ($arrIdAnimal as $animalId) {
                array_push($arrayId , $animalId["id_animal"]);
            }

            $request = $_SESSION["save_request"] . " AND id_animal IN (" .  implode(',', $arrayId) . ")";
        }
        else
            $request = 'SELECT * FROM Animal ORDER BY '. $sort;

        if (isset($_SESSION["premier_filter"]) || isset($_SESSION["parPage_filter"]))
            $request .= $sort . ' LIMIT ' . $_SESSION["premier_filter"] . ', ' . $_SESSION["parPage_filter"];
        else
            $request = $_SESSION["save_request"] . ' ' . $sort;
}

var_dump($request);

$animals = $connAjax->execRequest($request);

if (count($animals) > 0) {
    require "../components/tableSnakeHead.php";

    foreach ($animals as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "../components/tableSnakeContent.php";
    }

    require "../components/tableSnakeEnd.php";
    require "../components/pagination.php";
} else {
    echo "<div class='row mt-5 text-center'>
        <div class='alert alert-danger col-md-6 offset-md-3' role='alert'>
        Pas de résultat pour cette recherche
        </div>
    </div>";
}