<?php
$nom = "nom";
$id_race = "id_race";
$genre = "genre";
$poids = "poids";
$duree_vie = "duree_vie";
$date_naissance = "date_naissance";
$arrId = isset($lstAnimalId) ? json_encode($lstAnimalId, true) : "";
echo
"<table class='table align-middle mb-0 bg-white card-body p-5 text-center'>
    <thead class='bg-light'>
        <tr>
        <th>Nom <img onclick=\"triColonne('nom', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triNom'></th>
        <th>Race <img onclick=\"triColonne('id_race', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triRace'></th>
        <th>Genre <img onclick=\"triColonne('genre', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triGenre'></th>
        <th>Poids <img onclick=\"triColonne('poids', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triPoids'></th>
        <th>Durée de vie <img onclick=\"triColonne('duree_vie', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triVie'></th>
        <th>Date de naissance <img onclick=\"triColonne('date_naissance', this.id)\" class='arrow-tri' src='../img/others/tri-asc.png' id='triNaissance'></th>
         <th>Actions</th>
        </tr>
    </thead>
<tbody>";
?>