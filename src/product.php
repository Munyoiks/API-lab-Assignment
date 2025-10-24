<?php
namespace Group6\PhpOopLabs;

use PDO;

class Database {
    private $host = "localhost";
    private $db_name = "php_lab_db"; 
    private $username = "root"; 
    private $password = "munyoiks7";     
    private $conn;

    public function connect() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name}",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                echo "Connection error: " . $e->getMessage();
            }
        }
        return $this->conn;
    }
}

class Product {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllProducts() {
       $stmt = $this->conn->query("SELECT id, name, description, price, created_at FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConnection() {
        return $this->conn;
    }
}
