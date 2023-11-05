<?php
echo "<tr>
        <td>
            <div class='d-flex align-items-center'>
                <img src='../img/snake-img/" . $animal["path_img"] . "'" .
                "class='rounded-circle'
                alt=''
                style='width: 55px; height: 55px'
                    />
                <div class='ms-3'>"
                    . $animal["nom"] .
                    "</div>
            </div>
        </td>
        <td>" .
            \classes\Race::getRace($animal["id_race"]) .
            "</td>
        <td>" .
             $sexe.
            "</td>
        <td>" .
            $poids .
            "</td>
        <td>" .
            $a->convertDureeVieEnString($animal["duree_vie"]) .
            "</td>
        <td>" .
            $a->convertDateNaissanceToDateTime($animal["date_naissance"]).
            "</td>
        <td>
            <a type='button' class='btn btn-warning' href='../index.php?page=updtSnake&id=" . $animal["id_animal"] . "'>Modifier</a>
            <a type='button' class='btn btn-danger' href='../index.php?page=deleteSnake&id=" . $animal["id_animal"] . "'>Modifier</a>
        </td>
    </tr>";