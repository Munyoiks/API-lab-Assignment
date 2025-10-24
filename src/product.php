<?php
namespace Group6\PhpOopLabs;

use PDO;

class Product {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT id, name, description, price, created_at FROM products");
        return $stmt->fetchAll();
    }
}