<?php
require("../classes/Bdd.php");

$connAjax = new \classes\Bdd();

// Récupération des races disponibles + id correspondant
$races = $connAjax->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

// Création d'un tableau des valeurs passées dans le filtre
$arr = [];

// Vérification que les valueurs ne sont pas vides et si pas vide, ajout dans le tableau
$name = (isset($_POST["nom"]) && !empty($_POST["nom"])) ? $arr["nom"] = htmlspecialchars(trim($_POST["nom"])) : "";
$race = (isset($_POST["id_race"]) && $_POST["id_race"] != "Rechercher par race") ? $arr["id_race"] =  htmlspecialchars(trim($_POST["id_race"])) : "";
$genre = (isset($_POST["genre"]) && $_POST["genre"] != "Rechercher par genre") ? $arr["genre"] =  htmlspecialchars(trim($_POST["genre"])) : "";

// Si l'ensemble du formulaire est vide on retourne un message d'erreur
if (empty($name) && empty($race) && empty($genre))
{
    echo '
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  <strong>Oops!</strong> Merci de remplir au moins un des champs
	  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	';
} else {
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

    $res = $connAjax->execRequest($request);

    var_dump($res);

}