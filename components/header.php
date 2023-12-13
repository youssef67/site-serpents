<div class="row">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="../img/others/logo.png"
                 class="rounded-circle"
                 alt=""
                 style="width: 50px; height: 50px"
            />
            <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link"  href="index.php">Home</a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="index.php?page=vivarium">Vivarium</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=loveRoom">Love room</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=cimetiere">Cimetière</a>
                    </li>
                </ul>
                <?php if(isset($_REQUEST["page"]) && ($_REQUEST["page"] == "vivarium" || $_REQUEST["page"] == "loveRoom" || $_REQUEST["page"] == "cimetiere")) { ?>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- Button trigger modal -->
                            <a class="nav-link" id="confirmChangeSnake" data-bs-toggle="modal" data-bs-target="#editSelectSnake" style="display: none">confirmer selection</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link"  href="index.php?page=updtSnake&id=new">Créer un nouveau Serpent</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- Button trigger modal -->
                            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#addSnakes">Ajouter plusieurs serpents</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</div>
<!-- Modal pour peuplement snake -->
<!-- Modal -->
<div class="modal fade" id="addSnakes" tabindex="-1" aria-labelledby="addSnakes" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title-addSnakes">Ajouter plusieurs serpents</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddSnakes">
                    <div class="mb-4">
                        <label for="add-nbSerpents" class="col-form-label">Nombre de serpents :</label>
                        <input type="number" class="form-control" id="add-nbSerpents" name="formAddSnakes_nbSerpents">
                    </div>
                    <div class="mb-4">
                        <label for="add-raceSerpent" class="col-form-label">Races :</label>
                        <select class="selectpicker" multiple data-width="70%" title="Selection de la race" id="formAddSnakes_race" name="formAddSnakes_race">
                            <?php foreach($arr_race as $k => $v) { ?>
                                <option value="<?= $k?>"><?= $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="add-genderSerpent" class="col-form-label">Genres :</label>
                        <select class="selectpicker" multiple title="Selection du genre" data-width="70%" id="formAddSnakes_genre" name="formAddSnakes_genre">
                            <option value="1">Femelle</option>
                            <option value="2">Mâle</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" onclick="return ajaxAjoutSerpents()" data-bs-dismiss="modal" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal pour la confirmation de changement de partenaire -->
<!-- Modal -->
<div class="modal fade" id="editSelectSnake" tabindex="-1" aria-labelledby="editSelectSnake" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_editSelectSnake"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 text-center">
                    <p style="text-decoration: underline; font-weight: bold">Actuellement en sélection : </p>
                    <p>Nom : <span id="alreadySelected_name"></span></p>
                    <p>Race : <span id="alreadySelected_race"></span></p>
                    <p class="mt-2" style="text-decoration: underline; font-weight: bold">Remplacé par : </p>
                    <p>Nom : <span id="newSelected_name"></span> </p>
                    <p>Race : <span id="newSelected_race"></span></p>
                    <!-- On affiche dans le DOM l'id du serpent qui va peut etre envoyer en loveroom-->
                    <p id="id_serpent_select" style="opacity: 0"></p>
                    <p id="genre_serpent_select" style="opacity: 0"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="button_changeSelect" onclick="enregistrementSerpentSession('', '')" data-bs-dismiss="modal" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</div>

