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
        <th>poids (kg)</th>
        <th>durée de vie (en minutes)</th>
        <th>date de naissance</th>
    </tr>
    </thead>
<tbody>

<?php
foreach ($lstAnimal as $animal) { ?>
    <tr>
        <td>
            <?= $animal["nom"] ?>
        </td>
        <td>
            <?= \classes\Race::getRace($animal["id_race"]) ?>
        </td>
        <td>
            <?= $animal["genre"] == 1 ? "mâle" : "femelle" ?>
        </td>
        <td>
            <?= $animal["poids"] ?>
        </td>
        <td>
            <?= $animal["duree_vie"] / 60 ?>
        </td>
        <td>
            <?= $animal["date_naissance"] ?>
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
