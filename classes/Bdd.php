<?php

namespace classes;
use PDO;

class Bdd
{
    private \PDO $conn;

    public function __construct($h="localhost", $db="gestionAnimal", $u="mariadb", $pw="mariadb*1") {
        $this->conn = new PDO("mysql:host=$h;dbname=$db", $u, $pw);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execRequest($req)  {
        $reqStart = explode(' ', trim($req));
        $typeRequest = $reqStart[0];

        if ($typeRequest == "INSERT" || $typeRequest == "UPDATE" || $typeRequest == "SELECT") {
            $res = $this->conn->query($req);

            if($typeRequest == "SELECT") $res = $res->fetchAll(PDO::FETCH_ASSOC);
            if($typeRequest == "INSERT") $res = $this->conn->lastInsertId();

            return $res;
        } else {
            return false;
        }
    }

    public function create($table) {
        $request = "INSERT INTO `" . $table . "` (`id_" . strtolower($table) . "`) VALUES (NULL)";
        return $this->execRequest($request);
    }

    public function update($table, $id, $col, $value) {
        $request = "UPDATE `" . $table . "` SET `" . $col . "` = '" . addslashes($value) . "' WHERE `id_" . $table . "` = " . $id;
        $this->execRequest($request);
    }

    public function select($table, $id, $col) {
        $request = "SELECT `" . $col . "` FROM `" . $table . "` WHERE `id_" . $table . "` = " . $id;
        $res = $this->execRequest($request);

        $resStripSlashes = $res[0][$col] != null ? stripslashes($res[0][$col]) : $res[0][$col];
        return $resStripSlashes;
    }

    public function delete($table, $id) {
        $request = "UPDATE `" . $table . "` SET `delete_at` = NOW() WHERE `id_" . $table . "` = " . $id;
        $this->conn->query($request);
    }

    public function deleteEntriesNull($table, $col) {
        $request = "DELETE FROM `" . $table . "` WHERE `" . $col . "` IS NULL AND delete_at IS NULL";
        $this->conn->query($request);
    }
}