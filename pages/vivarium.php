<?php
require_once("classes/Bdd.php");
require_once("classes/Animal.php");
require_once("classes/Race.php");

$a = new \classes\Animal();
$lstAnimal = $a->selectAll();

?>

<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
    <tr>
        <th>Nom</th>
        <th>Race</th>
        <th>genre</th>
        <th>poids</th>
        <th>durée de vie</th>
        <th>date de naissance</th>
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
            <?= $animal["date_naissance"] ?>
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
