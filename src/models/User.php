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

    public function create(array $data): int
    {
        $sql = "INSERT INTO guests(firstname, lastname, email) VALUES(:firstname,:lastname,:email)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":firstname", $data['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(":lastname", $data['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);
            return $stmt->execute();
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function update(array $data, string $id): int
    {
        $sql = "UPDATE guests SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":firstname", $data['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(":lastname", $data['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (CustomException $e) {
            $e->render();
        }
    }
}
