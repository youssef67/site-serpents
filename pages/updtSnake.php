<?php
require_once("classes/Bdd.php");
require_once("classes/Animal.php");
require_once("classes/Race.php");
$s = new \classes\Animal($_GET["id"]);
$conn = new \classes\Bdd();

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
       <script>
            function erreurForm() {
                 swal({
                        text: "L\'ensemble des champs doivent être complétés",
                        icon: "error",
                        timer: 4000
                 })
            }
      </script>';

// Récupération des races disponibles + id correspondant
$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");

if(isset($_POST["sub_snake"])) {

    if(empty($_POST["nom"]) ||
        empty($_POST["id_race"]) ||
        empty($_POST["date_naissance"]) ||
        empty($_POST["genre"]) ||
        empty($_POST["poids"]) ||
        empty($_POST["duree_vie"])) {

        echo '<script>erreurForm();</script>';

    } else {
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

        $convertMinuteToSeconde = $_POST["duree_vie"] * 60;

        $dateMortTimeStamp = strtotime($_POST["date_naissance"]) + $convertMinuteToSeconde;
        $dateMortToString = date("d-m-Y H:i:s", $dateMortTimeStamp);

        $date = new DateTime($dateMortToString);

        $s->set("date_mort", $date->format("Y-m-d H:i:s"));

        //Ajout du serpent en BDD
        foreach ($_POST as $key => $value) {
            if ($key != "sub_snake") {

                //Conversion du poid en kgs en grammes
                if ($key == "poids") $value = $value * 1000;

                $s->set($key, $value);
            }
        }

        if ($_GET['id'] === "new") {
    ?>
            <script>
                window.location = 'index.php?page=vivarium';
                localStorage.setItem("operation", "new")
            </script>
    <?php
        } else {
    ?>
            <script>
                window.location = 'index.php?page=vivarium';
                localStorage.setItem("operation", "update")
            </script>
    <?php
        }
    }

}

// Création d'une date qui indique l'instant présent et qui permet de pré-remplir le champq de la date
$dateTemp = strtotime("now");
$dateTempToString = date("Y-m-d H:i:s", $dateTemp);

?>
<div class="row">
    <form action="" method="POST" class="col">
        <div class="card-body p-5 text-center">
            <?php
                if ($_GET['id'] === "new") {
            ?>
                <h1 class="fw-bold mb-0">Création d'un serpent</h1>
            <?php
                } else {
            ?>
                <h1 class="fw-bold mb-0">Modification de <?= $s->get("nom") ?></h1>
            <?php } ?>
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
                  <div class="col d-flex justify-content-start align-items-center">
                      <label class="form-label" for="naissance" id="input-date" style="margin-right: 20px; width: 50%; white-space: nowrap;">Veuillez définir la date de naissance</label>
                      <div class="form-outline">
                          <input type="datetime-local" id="naissance" class="form-control" name="date_naissance" value="<?= empty($s->get("date_naissance")) ? $dateTempToString : $s->get("date_naissance") ?>"/>
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
                  <div class="col">
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
                  <div class="col">
                      <label class="form-label" for="customRange1">Merci d'indiquer son espérance de vie en minute</label>
                      <div class="range">
                          <input
                              name="duree_vie"
                              type="range" class="form-range"
                              id="customRange1" min="2"
                              max="15"
                              value="<?= $s->get("duree_vie") ?>"
                          />
                      </div>
                  </div>
              </div>
            <input class="btn btn-primary btn-lg btn-rounded gradient-custom text-body px-5 mb-5 mt-5" type="submit" name="sub_snake" value="Enregistrer" style="color: white !important;"/>
          </div>
    </form>
</div>
