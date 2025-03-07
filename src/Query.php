<?php

namespace Query;

use DB\Database;
use Exceptions\CustomException;
use PDO;

class Query
{
    protected $table;
    protected $primary_key;
    private $conn;

    public function __construct($table, $primary_key)
    {
        $this->table = $table;
        $this->primary_key = $primary_key;
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create(array $data): int
    {
        try {
            $sql = "INSERT INTO guests(firstname, lastname, email) VALUES(:firstname,:lastname,:email)";
            $stmt = $this->conn->prepare($sql);
            $this->bind($stmt, ":firstname", $data['firstname']);
            $this->bind($stmt, ":lastname", $data['lastname']);
            $this->bind($stmt, ":email", $data['email']);
            return $stmt->execute();
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function fetchAll()
    {
        try {
            $sql = "SELECT * FROM $this->table";
            return $this->query($sql);
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function fetchById($id)
    {
        try {
            $sql = "SELECT * FROM $this->table WHERE $this->primary_key=:id";
            $stmt = $this->conn->prepare($sql);
            $this->bind($stmt, ":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function update(array $data, string $id): int
    {
        try {
            $sql = "UPDATE guests SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $this->bind($stmt, ":firstname", $data['firstname']);
            $this->bind($stmt, ":lastname", $data['lastname']);
            $this->bind($stmt, ":email", $data['email']);
            $this->bind($stmt, ":id", $id);
            return $stmt->execute();
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function delete(string $id): int
    {
        try {
            $sql = "DELETE FROM guests WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $this->bind($stmt, ":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (CustomException $e) {
            $e->render();
        }
    }

    private function query($sql)
    {
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    private function bind($stmt, $parameter, $value, $return_type = PDO::PARAM_STR)
    {
        $stmt->bindValue($parameter, $value, $return_type);
    }
}
