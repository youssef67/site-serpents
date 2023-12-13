<script>
    window.onload = function() {
        miseAjourSerpentMort();
    }
</script>
<?php
require_once("classes/Bdd.php");
require_once("classes/Race.php");
require_once("classes/Animal.php");

$a = new \classes\Animal();
$conn = new \classes\Bdd();

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

$_SESSION["currentPage"] = 1;

//Nombre de serpents par page
$parPage = 5;

// Calcul du nombre de pages nécessaires pour la pagination
$pages =  ceil($a->selectCountAllDeadSnake() / $parPage);

//Calcul du 1er serpent de la liste
$premier = ($_SESSION["currentPage"] * $parPage) - $parPage;

//Affichage des serpents morts  en BDD
$lstAnimal = $a->selectAllDeadSnake($premier, $parPage);

//Variables permettant de définir si on se trouve sur une page qui affiche les serpents morts ou les serpents vivants
//Si Serpents mort = true
//Si serpents vivant = false
$_SESSION["current_url"] = "cimetiere";
?>
<div class="row mt-5 text-center">
    <h3 class="col-3 fancy">
        Le cimetière
    </h3>
    <p class="mt-4" style="font-size: 1.5em">Les morts vivent à tout jamais dans nos coeurs</p>
</div>
<div class="row text-center mt-3">
    <div class="col">
        <img src="../img/others/rip.png"
             class="rounded-circle"
             alt=""
             style="width: 120px; height: 120px"
        />
        <p style="font-weight: bold; font-size: 25px"><span id="nbMorts"><?= $a->selectCountAllDeadSnake()?></span> serpents morts </p>
    </div>
</div>
<div class="row text-center mt-3">
    <div class="col">
        <a type="button" href="../index.php?page=cimetiere" class="btn-reactualiser">Reactualiser</a>
    </div>
</div>

<div id="lstSnakes">
<?php if (count($lstAnimal) > 0) { ?>
    <table class='table align-middle mb-5 bg-white card-body p-5 text-center'>
        <thead class='bg-light'>
        <tr>
            <th>Nom</th>
            <th>Race</th>
            <th>Genre</th>
            <th>date de mort</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($lstAnimal as $animal) {
            $sexe = $animal["genre"] == 2 ? "mâle" : "femelle";
        ?>
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <img src='../img/snake-img/<?= $animal["path_img"] ?>'
                     class='rounded-circle'
                    alt=''
                    style='width: 55px; height: 55px'
                    />
                    <div class='ms-3'><?= $animal["nom"] ?></div>
                </div>
            </td>
            <td><?= \classes\Race::getRace($animal["id_race"]) ?></td>
            <td><?= $sexe ?></td>
            <td><?= date("d-m-Y H:i:s", strtotime($animal["date_mort"])) ?></td>
        </tr>

        <?php }

        require "components/tableSnakeEnd.php";
        require "components/pagination.php";
        ?>
    </div>
<?php } else { ?>
    <div class="row p-5 text-center" >
        <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert">
            Pas de serpents morts
        </div>
    </div>
<?php } ?>
</div>


