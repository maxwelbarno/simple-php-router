<?php

namespace Model;

use DB\Database;
use Exceptions\CustomException;
use PDO;

class User
{
    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM guests";
        try {
            if ($this->conn) {
                $statement = $this->conn->query($sql);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (CustomException $e) {
            $e->render();
        }
    }
}
