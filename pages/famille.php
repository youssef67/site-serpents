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

$mort = "mort";
$vivant = "vivant";

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

//Serpent sur nous allons présenter l'arbre généalogique
$serpentCible = $a->selectById($_GET['id']);

//Recherche du pere
$pere = $a->selectById($serpentCible[0]["id_pere"]);
//Recherche de la mere
$mere = $a->selectById($serpentCible[0]["id_mere"]);



var_dump($pere);

?>
<div class="row mt-5 text-center">
    <h3 class="col-3 fancy">Arbre généalogique de <?= $serpentCible[0]["nom"] ?></h3>
</div>
<div class="row text-center mt-3">
    <div class="col">
        <img src="../img/snake-img/<?= $serpentCible[0]["path_img"] ?>" class="rounded-circle" style="width: 120px; height: 120px"/>
    </div>
</div>
<!-- ///////// Listing des parents ////////////-->
<div class="row mt-5 text-center">
    <div class="col ">
        <h4 class="col-3 fancy">Parents</h4>
        <div id="lstParents">
            <table class="table align-middle mb-0 bg-white card-body p-5 text-center">
                <thead class='bg-light'>
                <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Poids</th>
                    <th>Date de naissance</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
<!--                ////// Pere //////-->
                <tr>
                    <td>Père</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="../img/snake-img/<?= $pere[0]["path_img"] ?>" class='rounded-circle' style='width: 55px; height: 55px'/>
                            <div class='ms-3'><?= $pere[0]["nom"] ?></div>
                        </div>
                    </td>
                    <td><?= \classes\Race::getRace($pere[0]["id_race"]) ?></td>
                    <td><?= $pere[0]["poids"] ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($pere[0]["date_naissance"])) ?></td>
                    <td><?= empty($pere[0]["delete_at"]) ? $vivant :  $mort ?></td>
                    <td><a href="index.php?page=famille&id=<?= $pere[0]["id_animal"] ?>" type="button" class="btn btn-list" style="background-color: #F27438;">Voir l'arbre généalogique</a></td>
                </tr>
<!--                ////// Mere //////-->
                <tr>
                    <td>Mère</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="../img/snake-img/<?= $mere[0]["path_img"] ?>" class='rounded-circle' style='width: 55px; height: 55px'/>
                            <div class='ms-3'><?= $mere[0]["nom"] ?></div>
                        </div>
                    </td>
                    <td><?= \classes\Race::getRace($mere[0]["id_race"]) ?></td>
                    <td><?= $mere[0]["poids"] ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($mere[0]["date_naissance"])) ?></td>
                    <td><?= empty($mere[0]["delete_at"]) ? $vivant . "e" :  $mort ?></td>
                    <td><a href="index.php?page=famille&id=<?= $mere[0]["id_animal"] ?>" type="button" class="btn btn-list" style="background-color: #F27438;">Voir l'arbre généalogique</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-5 text-center">
    <h4 class="col-3 fancy">Enfants</h4>
</div>