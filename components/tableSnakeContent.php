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
            $animal["duree_vie"] .
            " minutes</td>
        <td>" .
            date("d-m-Y H:i:s", strtotime($animal["date_naissance"])) .
            "</td>
        <td>";

        echo "<a type='button' class='btn btn-list' style='background-color: #0B486B' onclick='checkSnakeSelected(" . $animal["id_animal"] . ", " .$animal["genre"] .")'><i class='bi bi-arrow-through-heart-fill'></i></a>
              <a type='button' class='btn btn-warning' href='../index.php?page=updtSnake&id=" . $animal["id_animal"] . "'><i class='bi bi-pencil'></i></a>
              <a type='button' class='btn btn-danger' onclick='deleteSerpent(". $animal["id_animal"] .")'  ><i class='bi bi-trash'></i></a>
        </td>
    </tr>";