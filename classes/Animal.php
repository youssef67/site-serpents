<?php

namespace classes;

use IntlDateFormatter;

class Animal
{
    public $conn;
    private $table = "Animal";
    private $id = "";

    public function __construct($myid = "vide")
    {
        $this->conn = new Bdd();
        if ($myid != "vide" && $myid != "new") $this->id = $myid;
        if ($myid == "new") {
            $this->id = $this->conn->create($this->table);
        }
    }

    public function selectAll($premier, $parPage) {
        return $this->conn->execRequest("SELECT * FROM 
             `" . $this->table . "` 
             WHERE delete_at IS NULL 
             ORDER BY `nom` DESC LIMIT " . $premier . ", " . $parPage);


    }

    public function get($col) {
        return $this->conn->select($this->table, $this->id, $col);
    }

    public function set($col, $value) {
        return $this->conn->update($this->table, $this->id, $col, $value);
    }

    public function deleteEntriesNull() {
        $this->conn->deleteEntriesNull($this->table, "genre");
    }

    public function selectCountAll() {
        $res = $this->conn->execRequest("SELECT COUNT(*) AS nbSnake FROM `" . $this->table . "` WHERE delete_at IS NULL");
        return $res[0]["nbSnake"];
    }
    public function selectAllCountByGender($col, $value) {
        $res = $this->conn->execRequest("SELECT COUNT(*) AS nbSnake 
                FROM `" . $this->table . "` 
                WHERE `" . $col . "` LIKE " . $value . " AND delete_at IS NULL");
        return $res[0]["nbSnake"];
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