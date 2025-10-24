<?php
namespace Group6\PhpOopLabs;

use PDO;
use Exception;

class Database {
    private $host = "localhost";
    private $db_name = "php_lab_db";  // <-- change to your actual DB
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
                throw new Exception("Database connection error: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getUserById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT id, name, email FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null; // returns null if user not found
    }

    public function register(string $name, string $email, string $password, string $secret): string {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO users (name, email, password, secret) VALUES (:name, :email, :password, :secret)"
            );

            $stmt->execute([
                ':name'     => $name,
                ':email'    => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':secret'   => $secret
            ]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }

    public function getUserByEmail(string $email): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function verifyPassword(string $email, string $password): bool {
        $user = $this->getUserByEmail($email);
        if (!$user) return false;

        return password_verify($password, $user['password']);
    }

    public function getConnection(): PDO {
        return $this->conn;
    }
}
