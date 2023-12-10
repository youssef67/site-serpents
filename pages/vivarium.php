<script>
    window.onload = function() {
        miseAjourSerpentMort();
    }
</script>
<?php
require_once("classes/Bdd.php");
require_once("classes/Race.php");
require_once("classes/Animal.php");

unset($_SESSION["nb_resultat_filtre"]);
unset($_SESSION["pages"]);
unset($_SESSION["save_request"]);

$a = new \classes\Animal();
$conn = new \classes\Bdd();

// Suppresion des entrées crée avec la création d'un serpent
$a->deleteEntriesNull();

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

// On determine sur quelle page on se trouve
$_SESSION["currentPage"] = 1;

//Nombre de serpents par page
$parPage = 5;

// Calcul du nombre de pages nécessaires pour la pagination
$pages =  ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
$lstAnimal = $a->selectAll($premier, $parPage);

//Variables permettant de définir si on se trouve sur une page qui affiche les serpents morts ou les serpents vivants
//Si Serpents mort = true
//Si serpents vivant = false
$_SESSION["current_url"] = "vivarium";

?>
<!-- Mise en place de la bannière afin de confirmer la modification -->
<?php if (isset($_GET["update"]) && $_GET["update"] === true) { ?>
<div class="row p-5 text-center update">
    <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert">
        Modification effectuée
    </div>
</div>
<?php } ?>
<div id="display"></div>
<!-- Affichage du nombre de mâle et de femelle dans la liste-->
<div class="row mt-5 text-center">
    <h3 class="col-3 fancy">
        Actuellement,
        <span id="nbTotal"><?= $a->selectCountAll() ?></span>
        serpents présents dans la ferme
    </h3>
</div>
<div class="row text-center mt-3">
    <div class="col-4"></div>
    <div class="col-2">
        <img src="../img/others/icons-femelle.png"
             class="rounded-circle"
             alt=""
             style="width: 120px; height: 120px"
        />
        <p style="font-weight: bold"><span id="nbFemelles"><?= $a->selectAllCountByGender("genre", 1)?></span> femelles </p>
    </div>
    <div class="col-2">
        <img src="../img/others/icons-male.png"
             class="rounded-circle"
             alt=""
             style="width: 120px; height: 120px"
        />
        <p style="font-weight: bold" ><span id="nbMales"><?= $a->selectAllCountByGender("genre", 2)?></span> mâles</p>
    </div>
    <div class="col-4"></div>
</div>


<!-- Mise en place des filtres -->
<!-- Recherche par nom -->
<!-- Recherche par genre -->
<!-- Recherche par race -->
    <div class="row text-center mt-5 ">
        <h3 class="col-2 fancy">
            Liste des serpents
        </h3>
    </div>
    <form id="formFilters" enctype="multipart/form-data" name="formFilter">
        <div class="row mt-5">
            <div class="col inputFilterFormEmpty"></div>
            <div class="col inputFilterForm">
                <input name="nom" type="text" class="input input-gradient form-control" placeholder="Rechercher par nom" id="nom_filter">
            </div>
            <div class="col inputFilterForm">
                <select type="text" class="input input-gradient form-control" name="id_race" id="race_filter">
                    <option selected>Rechercher par race</option>
                    <?php foreach ($races as $race) { ?>
                        <option
                            <?= $race["id_race"] ?>
                                value="<?= $race["id_race"] ?>"><?= $race["nom_race"] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col inputFilterForm">
                <select type="text" class="input input-gradient form-control" name="genre" id="genre_fitler">
                    <option selected>Rechercher par genre</option>
                    <option value="1">femelle</option>
                    <option value="2">mâle</option>
                </select>
            </div>
            <div class="col" id="validationFilterForm">
                <button type="button" onclick="validateForm()" class="btn-filter btn-gradient form-control" style="font-weight: bold">Rechercher</button>
            </div>
            <div class="col inputFilterFormEmpty"></div>
        </div>
    </form>


<div class="row p-5 text-center confirmSelectedSnake" style="display: none">
    <div class="alert alert-success col-md-6 offset-md-3 justify-content-center content-confirmSelectedSnake" role="alert">
    </div>
</div>
<!-- Début de la liste des serpents-->
<div class="row text-center" style="display: none" id="info">
    <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert" id="info-text">
    </div>
</div>
<div id="lstSnakes">
<?php if (count($lstAnimal) > 0) {

    require "components/tableSnakeHead.php";

    foreach ($lstAnimal as $animal) {
        $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        $poids = $animal["poids"] / 1000 . " kg";

        require "components/tableSnakeContent.php";
    }
    require "components/tableSnakeEnd.php";
    require "components/pagination.php";

    ?>
</div>
<?php
} else { ?>
        <div class="row p-5 text-center" >
            <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert">
                    Pas de serpents enregixxstrés
            </div>
        </div>
<?php } ?>
