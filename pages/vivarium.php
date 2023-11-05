<?php
require("classes/Bdd.php");
require_once("classes/Race.php");
require_once("classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();


$a->deleteEntriesNull();
$lstAnimal = $a->selectAll();

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");
?>
<!-- Mise en place de la bannière afin de confirmer la modification/suppression -->
<?php if (isset($_GET["done"])) { ?>
<div class="row p-5 text-center update" >
    <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert">
        <?php if ($_GET["done"] == "update") { ?>
            Modification effectuée
        <?php } else { ?>
            Suppression effectuée
        <?php } ?>
    </div>
</div>
<?php } ?>

<!-- Affichage du nombre de mâle et de femelle dans la liste-->
<div class="row mt-5 text-center">
    <h3 class="col-3 fancy">
        Actuellement,
        <?= $a->selectAllCount("genre", 1) + $a->selectAllCount("genre", 2) ?>
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
        <p style="font-weight: bold"><?= $a->selectAllCount("genre", 1)?> femelles </p>
    </div>
    <div class="col-2">
        <img src="../img/others/icons-male.png"
             class="rounded-circle"
             alt=""
             style="width: 120px; height: 120px"
        />
        <p style="font-weight: bold"><?= $a->selectAllCount("genre", 2)?> mâles</p>
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
        <div class="row mt-5 text-center" style="display: none" id="error-filters">
            <div class="alert alert-warning col-md-6 offset-md-3" role="alert">
                Merci d'indiquer au moins un critère de recherche
            </div>
        </div>
        <div class="row mt-5">
            <div class="col"></div>
            <div class="col">
                <input name="nom" type="text" class="input input-gradient form-control" placeholder="Rechercher par nom">
            </div>
            <div class="col">
                <select type="text" class="input input-gradient form-control" name="id_race">
                    <option selected>Rechercher par race</option>
                    <?php foreach ($races as $race) { ?>
                        <option
                            <?= $race["id_race"] ?>
                                value="<?= $race["id_race"] ?>"><?= $race["nom_race"] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col">
                <select type="text" class="input input-gradient form-control" name="genre">
                    <option selected>Rechercher par genre</option>
                    <option value="1">femelle</option>
                    <option value="2">mâle</option>
                </select>
            </div>
            <div class="col">
                <button type="button" onclick="return validateForm()" class="btn-filter btn-gradient form-control">Rechercher</button>
            </div>
            <div class="col"></div>
        </div>
    </form>

<!-- Début de la liste des serpents-->
<table class="table align-middle mb-0 bg-white card-body p-5 text-center" id="lstSnakes">
    <thead class="bg-light">
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
    <tbody>

<?php
foreach ($lstAnimal as $animal) {
    ?>
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <img src="../img/snake-img/<?= $animal["path_img"] ?>"
                     class="rounded-circle"
                     alt=""
                    style="width: 55px; height: 55px"
                />
                <div class="ms-3">
                    <?= $animal["nom"] ?>
                </div>
            </div>
        </td>
        <td>
            <?= \classes\Race::getRace($animal["id_race"]) ?>
        </td>
        <td>
            <?= $animal["genre"] == 2 ? "mâle" : "femelle" ?>
        </td>
        <td>
            <?= $animal["poids"] / 1000 . " kg"?>
        </td>
        <td>
            <?= $a->convertDureeVieEnString($animal["duree_vie"]);  ?>
        </td>
        <td>
            <?= $a->convertDateNaissanceToDateTime($animal["date_naissance"]); ?>
        </td>
        <td>
            <a type="button" class="btn btn-warning" href="../index.php?page=updtSnake&id=<?= $animal["id_animal"] ?>">Modifier</a>
            <a type="button" class="btn btn-danger" href="../index.php?page=deleteSnake&id=<?= $animal["id_animal"] ?>">Supprimer</a>
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
