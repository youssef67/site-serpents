<script>
    window.onload = function() {
        miseAjourSerpentMort();
        getLocalStoragetoSession();
    }
</script>
<?php
?>
<div class="row mt-5 text-center">
    <h3 class="col-3 fancy">
        La chambre nuptiale
    </h3>
    <p class="mt-4" style="font-size: 1.5em">Un lieu de plaisir et de rencontre innattendu</p>
    <p style="font-size: 1.5em">Si pas de papillons dans le ventre, laissez le hasard faire les choses !!!</p>
</div>
<div class="row text-center" style="display: none" id="info">
    <div class="alert alert-success col-md-6 offset-md-3 justify-content-center" role="alert" id="info-text">
    </div>
</div>
<div id="displayResult"></div>
<div class="mb-5">
    <div class="row mt-5">
        <div class="col-2"></div>
        <div class="col-3 align-items-end">
            <div class="row justify-content-center">
                <div class="col-2 dice">
                    <img src="/img/others/dice.png" class="card-img-top" alt="" onclick="randomChange(1)"/>
                </div>
            </div>
        </div>
        <div class="col-2">
        </div>
        <div class="col-3 align-items-end">
            <div class="row justify-content-center">
                <div class="col-2 dice">
                    <img src="/img/others/dice.png" class="card-img-top" alt="" onclick="randomChange(2)"/>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"></div>
        <div class="card col-3">
            <img src="/img/others/choisir-male.png" class="card-img-top" id="photoMale"/>
            <div class="card-body text-center">
                <h5 class="card-title-male-loveRoom">Mâle sélectionné</h5>
                <p id="idMale" style="display: none"></p>
                <p class="card-text" id="nomMaleLoveRoom"></p>
            </div>
        </div>
        <div class="col-2 d-flex align-items-center justify-content-center">
            <button onclick="accoupler()" class="btn_accoupler">accoupler</button>
        </div>
        <div class="card col-3">
            <img src="/img/others/choisir-femelle.png" class="card-img-top" id="photoFemelle"/>
            <div class="card-body text-center">
                <h5 class="card-title-femelle-loveRoom">Femelle Sélectionnée</h5>
                <p id="idFemelle" style="-display: none"></p>
                <p class="card-text" id="nomFemelleLoveRoom"></p>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>
