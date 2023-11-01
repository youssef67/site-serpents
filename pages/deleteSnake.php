<?php
require_once("classes/Bdd.php");

$conn = new \classes\Bdd();

$conn->delete("Animal", $_GET["id"]);

header('Location: index.php?page=vivarium&done=delete');
