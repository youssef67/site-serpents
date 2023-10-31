<?php

namespace classes;

class Race
{
    public $conn;
    private $table = "Race";
    private $id = "";


    public function __construct($myid = "vide") {
        $this->conn = new Bdd();
        if($myid != "vide" && $myid != "new") $this->id = $myid;
        if($myid = "new") $this->id = $this->conn->create($this->table);
    }

    public static function getRace($id) {
        $conn = new Bdd();

        $res =  $conn->execRequest("SELECT `nom_race` FROM `Race` WHERE `id_race` = " . $id);
        return $res[0]["nom_race"];
    }
    public function selectAll()
    {
       return $this->conn->select("SELECT * FROM `" . $this->table . "`");
    }

    public function selectOne($col) {
        return $this->conn->select($this->table, $this->id, $col);
    }

    public function set($col, $value) {
        return $this->conn->update($this->table, $this->id, $col, $value);
    }
}