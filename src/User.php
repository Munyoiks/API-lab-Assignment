<?php
// src/User.php
class User {
    private $name;
    private $email;
    private $password;
    private $secret;

    public function __construct($name, $email, $password, $secret) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->secret = $secret;
    }

    // Simulate user registration, return a fake user ID
    public function register() {
        // Here you would save the user to a database
        // For now, just return a random user ID
        return rand(1000, 9999);
    }
}
