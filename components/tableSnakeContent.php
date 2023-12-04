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
        <td>";

            $dataToCheck = [
                'sessionSnakeFemelle' => isset($_SESSION['femelle_selected']) ? $_SESSION['femelle_selected'] : 'null',
                'sessionSnakeMale' => isset($_SESSION['male_selected']) ? $_SESSION['male_selected'] : 'null',
                "idSnakeSelected" => $animal["id_animal"],
                "genreSnakeSelected" => $animal["genre"]
            ];

        echo "<a type='button' class='btn btn-list' style='background-color: #0B486B' onclick='checkSnakeSelected(" . json_encode($dataToCheck) . ")'><i class='bi bi-arrow-through-heart-fill'></i></a>
              <a type='button' class='btn btn-warning' href='../index.php?page=updtSnake&id=" . $animal["id_animal"] . "'><i class='bi bi-pencil'></i></a>
              <a type='button' class='btn btn-danger' onclick='deleteSerpent(". $animal["id_animal"] .")'  ><i class='bi bi-trash'></i></a>
        </td>
    </tr>";