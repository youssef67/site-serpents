<?php
session_start();

if (intval($_GET["gender"]) === 1) {
    if(isset($_SESSION["femelle_selected"]) && $_SESSION["femelle_selected"] === $_GET["id"]) {
        echo "sorry, voulez vous changer";
    } else {
        $_SESSION["femelle_selected"] = $_GET["id"];
    }
} else {
    if(isset($_SESSION["male_selected"]) && $_SESSION["male_selected"] === $_GET["id"]) {
        echo "sorry, voulez vous changer";
    } else {
        $_SESSION["male_selected"] = $_GET["id"];
    }
}
