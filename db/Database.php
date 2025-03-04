<?php

namespace DB;

use Controller\Controller;
use PDO;
use PDOException;

class Database extends Controller
{
    private $host = "localhost";
    private $username = "admin";
    private $password = "admin123";
    private $db = "phpDBtest";

    public function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8";
            return new PDO($dsn, $this->username, $this->password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            header('Content-Type: application/json; charset=UTF-8');
            http_response_code(500);
            echo json_encode(["code" => 500, "message" => $e->getMessage()]);

            exit();
        }
    }
}
