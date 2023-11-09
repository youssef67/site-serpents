<?php
require_once("classes/Bdd.php");
require_once("classes/Race.php");
require_once("classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

// Suppresion des entrées crée avec la création d'un serpent
$a->deleteEntriesNull();

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

// On determine sur quelle page on se trouve
if(!isset($_SESSION["currentPage"])) $_SESSION["currentPage"] = 1;

//Nombre de serpents par page
$parPage = 5;

// Calcul du nombre de pages nécessaires pour la pagination
$pages =  ceil($a->selectCountAll() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

//Affichage des serpents valides et présent en BDD
$lstAnimal = $a->selectAll($premier, $parPage);

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
        <?= $a->selectCountAll() ?>
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
        <p style="font-weight: bold"><?= $a->selectAllCountByGender("genre", 1)?> femelles </p>
    </div>
    <div class="col-2">
        <img src="../img/others/icons-male.png"
             class="rounded-circle"
             alt=""
             style="width: 120px; height: 120px"
        />
        <p style="font-weight: bold"><?= $a->selectAllCountByGender("genre", 2)?> mâles</p>
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
            <div class="col inputFilterFormEmpty"></div>
            <div class="col inputFilterForm">
                <input name="nom" type="text" class="input input-gradient form-control" placeholder="Rechercher par nom">
            </div>
            <div class="col inputFilterForm">
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
            <div class="col inputFilterForm">
                <select type="text" class="input input-gradient form-control" name="genre">
                    <option selected>Rechercher par genre</option>
                    <option value="1">femelle</option>
                    <option value="2">mâle</option>
                </select>
            </div>
            <div class="col" id="validationFilterForm">
                <button type="button" onclick="return validateForm()" class="btn-filter btn-gradient form-control">Rechercher</button>
            </div>
<!--            <div class="col-2" id="resetFilterForm">-->
<!--                <button type="button" onclick="return validateForm()" class="btn-filter btn-gradient form-control">Reset recherche</button>-->
<!--            </div>-->
            <div class="col inputFilterFormEmpty"></div>
        </div>
    </form>

<!-- Début de la liste des serpents-->
<div id="lstSnakes">
    <table class="table align-middle mb-0 bg-white card-body p-5 text-center">
        <thead class="bg-light">
        <tr>
            <th>Nom <img onclick="triColonne(type = 'nom', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triNom"/></th>
            <th>Race <img onclick="triColonne(type = 'id_race', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triRace"></th>
            <th>Genre <img onclick="triColonne(type = 'genre', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triGenre"></th>
            <th>Poids <img onclick="triColonne(type = 'poids', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triPoids"></th>
            <th>Durée de vie <img onclick="triColonne(type = 'duree_vie', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triVie"></th>
            <th>Date de naissance <img onclick="triColonne(type = 'date_naissance', this.id)" class="arrow-tri" src="../img/others/tri-desc.png" id="triNaissance"></th>
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
    <div class="row justify-content-md-center mt-3">
        <div class="col col-lg-2">
        </div>
        <nav class="col-md-auto">
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($_SESSION["currentPage"] == 1) ? "disabled" : "" ?>">
                    <a onclick="ajaxListSnake('pagination', <?=$_SESSION["currentPage"] - 1?>)" class="page-link">Précédente</a>
                </li>
                <?php for($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($_SESSION["currentPage"] == $page) ? "active" : "";    ?>">
    <!--                    <a href="../index.php?page=vivarium&nbPage=--><?php //= $page ?><!--" class="page-link">--><?php //= $page ?><!--</a>-->
                        <a onclick="ajaxListSnake('pagination', <?=$page?>)" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($_SESSION["currentPage"] == $pages) ? "disabled" : "" ?>">
                    <a onclick="ajaxListSnake('pagination', <?=$_SESSION["currentPage"] + 1?>)" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
        <div class="col col-lg-2">
        </div>
    </div>
</div>
