<?php
require_once("classes/Bdd.php");
require_once("classes/Animal.php");
require_once("classes/Race.php");

$s = new \classes\Animal($_GET["id"]);
$conn = new \classes\Bdd();

if(isset($_POST["sub_snake"])) {
    //Créer un tableau avec les noms des images
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

    $index = array_rand($fileList, 1);
    $s->set("path_img", $fileList[$index]);

    foreach ($_POST as $key => $value) {
        if ($key != "sub_snake") {

            if ($key == "poids") $value = $value * 1000;
            if ($key == "duree_vie") $value = $value * 60;

            $s->set($key, $value);
        }
    }
}

$races = $conn->execRequest("SELECT `id_race`, `nom_race` FROM `Race`");


?>
<form action="" method="POST">
      <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-8 col-xl-8">
          <div class="card" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="my-md-5 pb-5">

                <h1 class="fw-bold mb-0">Bienvenu dans la création d'un serpent</h1>
                  <img src="../img/others/serpent-formulaire.png"
                       class="rounded-circle mt-5"
                       style="width: 100px; height: 100px"
                  />

                  <div class="row mb-4 mt-5">
                      <div class="col">
                          <div class="form-outline">
                              <input type="text" id="nom" name="nom" class="form-control" />
                              <label class="form-label" for="nom" >Choisir le prénom</label>
                          </div>
                      </div>
                      <div class="col">
                          <select class="form-select" aria-label="Default select example" name="id_race">
                              <option selected>Veuillez choisir une race</option>
                              <?php foreach ($races as $race) { ?>
                                  <option  value="<?= $race["id_race"] ?>"><?= $race["nom_race"] ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-4 mt-5">
                      <div class="col">
                          <div class="form-outline">
                              <input type="date" id="naissance" class="form-control" name="date_naissance"/>
                              <label class="form-label" for="naissance" id="input-date">Veuillez définir une date</label>
                          </div>
                      </div>
                      <div class="col">
                          <select class="form-select" aria-label="Default select example" name="genre">
                              <option selected>Veuillez choisir le sexe</option>
                              <option value="0">Femelle</option>
                              <option value="0">Mâle</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-4 mt-5">
                      <label class="form-label" for="customRange1">Merci d'indiquer le poids</label>
                      <div class="range">
                          <input name="poids" type="range" class="form-range" id="customRange1" min="1" max="20" step="0.1" />
                      </div>
                  </div>

                  <div class="row mb-4 mt-5">
                      <label class="form-label" for="customRange1">Merci d'indiquer son espérance de vie en minute</label>
                      <div class="range">
                          <input name="duree_vie" type="range" class="form-range" id="customRange1" min="1" max="15" />
                      </div>
                  </div>

                <input
                        class="btn btn-primary btn-lg btn-rounded gradient-custom text-body px-5"
                        type="submit"
                        name="sub_snake"
                        value="Enregistrer"
                />

              </div>

            </div>
          </div>
        </div>
      </div>
</form>
