<?php
require_once("classes/Bdd.php");
require_once("classes/Animal.php");
require_once("classes/Race.php");

$a = new \classes\Animal();

$a->deleteEntriesNull();
$lstAnimal = $a->selectAll();

?>

<a type="button" class="btn btn-primary" href="index.php?page=updtSnake&id=new">Ajouter un serpent</a>
<table class="table align-middle mb-0 bg-white">
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
            <?= $animal["genre"] == 1 ? "mâle" : "femelle" ?>
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
            <a type="button" class="btn btn-danger">Supprimer</a>
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
