<?php
namespace Group6\PhpOopLabs;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $db_name = 'php_lab_db';
    private $username = 'root';
    private $password = 'munyoiks7';
    private $conn;

    public function connect() {
        if ($this->conn) {
            return $this->conn; // Reuse existing connection
        }

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
