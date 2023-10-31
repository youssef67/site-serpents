<?php

namespace classes;

use IntlDateFormatter;

class Animal
{
    public $conn;
    private $table = "Animal";
    public $id = "";

    public function __construct($myid = "vide")
    {
        $this->conn = new Bdd();
        if ($myid != "vide" && $myid != "new") $this->id = $myid;
        if ($myid == "new") {
            $this->id = $this->conn->create($this->table);
        }
    }

    public function selectAll() {
        return $this->conn->execRequest("SELECT * FROM `" . $this->table . "`");
    }

    public function selectOne($col) {
        return $this->conn->select($this->table, $this->id, $col);
    }

    public function set($col, $value) {
        return $this->conn->update($this->table, $this->id, $col, $value);
    }

    public function convertDureeVieEnString ($number) {
        $secondes = $number;

        $minutes = floor($secondes / 60);
        $secondes -= $minutes * 60;

        $minutesAvecSouSansS = $minutes > 1 ? " minutes " : "minute";

        $afficheDureeVie = $minutes . $minutesAvecSouSansS;

        if ($secondes > 0) {
            $secondesAvecSouSansS = $secondes > 1 ? " secondes" : " seconde";
            $afficheDureeVie .= " et " . $secondes . $secondesAvecSouSansS;
        }

        return $afficheDureeVie;
    }

    public function convertDateNaissanceToDateTime($chaine) {

        $date = new \DateTime();
        $timeStamp = strtotime($chaine);
        $date->setTimestamp($timeStamp);

        $parser = new \IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        );

        return $parser->format($date);
    }










}