<?php
require_once("classes/Bdd.php");
require_once("classes/Animal.php");
require_once("classes/Race.php");
$s = new \classes\Animal($_GET["id"]);
$conn = new \classes\Bdd();

if(isset($_POST["sub_snake"])) {

    //Créer un tableau avec les noms des fichiers d'images
    if ($s->get("path_img") == null) {
        $dir = "img/snake-img";
        $fileList = [];

        if(is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        $fileList[] = $file;
                    }
                }
                closedir($dh);
            }
        } else {
            var_dump("le dossier n'existe pas !");
        }

        // Selection d'un nom de fichier dans le tableau + ajout en BDD
        $index = array_rand($fileList, 1);
        $s->set("path_img", $fileList[$index]);
    }

    //Calcul espérance de vie en secondes
    $_POST["duree_vie"] = $_POST["duree_vie_minute"] * 60 + $_POST["duree_vie_seconde"];

    unset($_POST["duree_vie_minute"]);
    unset($_POST["duree_vie_seconde"]);

    //Ajout du serpent en BDD
    foreach ($_POST as $key => $value) {
        if ($key != "sub_snake") {

            //Conversion du poid en kgs en grammes
            if ($key == "poids") $value = $value * 1000;

            $s->set($key, $value);
        }
    }

    header('Location: index.php?page=vivarium&update=true');
}

//Si update d'un serpent, on calcul la durée de vie en minutes + secondes
$secondes = $s->get("duree_vie");
$minutes = floor($secondes / 60);
$secondes -= $minutes * 60;

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

?>
<div class="row">
    <form action="" method="POST" class="col">
        <div class="card-body p-5 text-center">
            <h1 class="fw-bold mb-0">Bienvenu dans la création d'un serpent</h1>
              <img src="../img/others/serpent-formulaire.png"
                   class="rounded-circle mt-5"
                   style="width: 100px; height: 100px"
              />

              <div class="row mb-4 mt-5">
                  <div class="col">
                      <div class="form-outline">
                          <input type="text" id="nom" name="nom" class="form-control" value="<?= $s->get("nom") ?>"/>
                          <label class="form-label" for="nom" >Choisir le prénom</label>
                      </div>
                  </div>
                  <div class="col">
                      <select class="form-select" aria-label="select race" name="id_race">
                          <option selected>Veuillez choisir une race</option>
                          <?php foreach ($races as $race) { ?>
                              <option
                                      <?= $s->get("id_race") == $race["id_race"] ? "selected" : ""?>
                                      value="<?= $race["id_race"] ?>"><?= $race["nom_race"] ?>
                              </option>
                          <?php } ?>
                      </select>
                  </div>
              </div>

              <div class="row mb-4 mt-5">
                  <div class="col">
                      <div class="form-outline">
                          <input type="date" id="naissance" class="form-control" name="date_naissance" value="<?= $s->get("date_naissance") ?>"/>
                          <label class="form-label" for="naissance" id="input-date">Veuillez définir une date</label>
                      </div>
                  </div>
                  <div class="col">
                      <select class="form-select" aria-label="select sexe" name="genre">
                          <option <?= $s->get("genre") == null ? "selected" : ""?>>Veuillez choisir le sexe</option>
                          <option <?= $s->get("genre") == 1 ? "selected" : ""?> value="1">Femelle</option>
                          <option <?= $s->get("genre") == 2 ? "selected" : ""?> value="2">Mâle</option>
                      </select>
                  </div>
              </div>

              <div class="row mb-4 mt-5">
                  <h3>Poids en Kg</h3>
              </div>
              <div class="row mb-4 mt-5">
                  <label class="form-label" for="customRange1">Merci d'indiquer le poids</label>
                  <div class="range">
                      <input
                              name="poids"
                              type="range"
                              class="form-range"
                              id="customRange1"
                              min="1" max="20"
                              step="0.1"
                              value="<?= $s->get("poids") / 1000 ?>"
                      />
                  </div>
              </div>

              <div class="row mb-4 mt-5">
                  <h3>Espérance de vie</h3>
              </div>
              <div class="row mb-4 mt-5">
                  <div class="col">
                      <label class="form-label" for="customRange1">Merci d'indiquer son espérance de vie en minute</label>
                      <div class="range">
                          <input
                                  name="duree_vie_minute"
                                  type="range" class="form-range"
                                  id="customRange1" min="1"
                                  max="15"
                                  value="<?= $minutes ?>"
                          />
                      </div>
                  </div>
                  <div class="col">
                      <label class="form-label" for="customRange1">Merci d'indiquer son espérance de vie en seconde</label>
                      <div class="range">
                          <input
                                  name="duree_vie_seconde"
                                  type="range" class="form-range"
                                  id="customRange1"
                                  min="0"
                                  max="60"
                                  value="<?= $secondes ?>"
                          />
                      </div>
                  </div>
              </div>

            <input class="btn btn-primary btn-lg btn-rounded gradient-custom text-body px-5" type="submit" name="sub_snake" value="Enregistrer"/>
          </div>
    </form>
</div>
