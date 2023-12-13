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
//$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

//Serpent sur nous allons présenter l'arbre généalogique
$serpentCible = $a->selectSnakeLiveOrDeadById($_GET['id']);

//Recherche du pere
$pere = is_null($serpentCible[0]["id_pere"]) ? [] : $a->selectParentById($serpentCible[0]["id_pere"]);

//Recherche de la mere
$mere = is_null($serpentCible[0]["id_mere"]) ? [] : $a->selectParentById($serpentCible[0]["id_mere"]);
//
////Enfants
$enfants = $a->selectAllByIdParent($_GET["id"], $serpentCible[0]["genre"]);

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
    <div class="col">
        <h4 class="col-3 fancy">Parents</h4>
            <table class="table align-middle mb-0 bg-white card-body mt-5 p-5 text-center">
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
                    <?php if (!empty($pere)) { ?>
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
                    <?php } else { ?>
                        <td colspan="7" style="font-weight: bold; font-size: 15px">Père inconnu</td>
                    <?php } ?>
                </tr>
<!--                ////// Mere //////-->
                <tr>
                    <?php if (!empty($mere)) { ?>
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
                    <?php } else { ?>
                        <td colspan="7" style="font-weight: bold; font-size: 15px">Mère inconnue</td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>
    </div>
</div>
<!--                ////// Enfants //////-->
<div class="row mt-5 text-center mb-5">
    <h4 class="col-3 fancy">Enfants</h4>
<?php if (count($enfants) > 0) { ?>
        <table class="table align-middle mb-0 bg-white card-body mt-5 p-5 text-center">
            <thead class='bg-light'>
            <tr>
                <th>Nom</th>
                <th>Race</th>
                <th>Sexe</th>
                <th>Poids</th>
                <th>Date de naissance</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
           <?php foreach ($enfants as $enfant) { ?>
                   <tr>
                       <td>
                           <div class="d-flex align-items-center">
                               <img src="../img/snake-img/<?= $enfant["path_img"] ?>" class='rounded-circle' style='width: 55px; height: 55px'/>
                               <div class='ms-3'><?= $enfant["nom"] ?></div>
                           </div>
                       </td>
                       <td><?= \classes\Race::getRace($enfant["id_race"]) ?></td>
                       <td><?= $enfant["genre"] === 1 ? "Femelle" : "Mâle" ?></td>
                       <td><?= $enfant["poids"] ?></td>
                       <td><?= date("d-m-Y H:i:s", strtotime($enfant["date_naissance"])) ?></td>
                       <td><?= empty($enfant["delete_at"]) ? $vivant . "e" :  $mort ?></td>
                       <td><a href="index.php?page=famille&id=<?= $enfant["id_animal"] ?>" type="button" class="btn btn-list" style="background-color: #F27438;">Voir l'arbre généalogique</a></td>
                   </tr>
            <?php } ?>
            </tbody>
        </table>
<?php }
else { ?>
        <div class="row">
            <p class="mt-4 p-5" style="font-weight: bold; font-size: 20px">Ce serpent n'a pas d'enfants</p>
        </div>
<?php } ?>
</div>