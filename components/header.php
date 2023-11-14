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
                <?php if(isset($_REQUEST["page"]) && $_REQUEST["page"] == "vivarium") { ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link"  href="index.php?page=updtSnake&id=new">Créer un nouveau Serpent</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- Button trigger modal -->
                            <a class="nav-link"  href="index.php?page=addSnakes" data-bs-toggle="modal" data-bs-target="#addSnakes">Ajouter plusieurs serpents</a>
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
            <div class="row mt-2" style="display: none" id="error_field_addSnakes">
                <div class="col-12">
                    <div class="alert alert-warning mb-4" role="alert">
                        Veuillez remplir l'ensemble des champs
                    </div>
                </div>
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
                        <select class="selectpicker" multiple title="Selection du sexe" data-width="70%" id="formAddSnakes_genre" name="formAddSnakes_genre">
                            <option value="1">Femelle</option>
                            <option value="2">Mâle</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" onclick="return ajaxAjoutSerpents()" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

