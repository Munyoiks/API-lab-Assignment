<?php
require 'vendor/autoload.php';
require 'User.php';
require_once 'vendor/phpgangsta/googleauthenticator/PHPGangsta/GoogleAuthenticator.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $twofa_code = trim($_POST['2fa_code']);

    // Provide the required arguments to the User constructor
    // Replace the placeholders with actual values as needed
    // Example: new User('localhost', 'your_db', 'db_user', 'db_pass');
    $userModel = new User('localhost', 'ianmunyoiks@gmail.com', 'munyoiks7', 'munyoiks7');
    // Assuming your User class has a public property $conn for the PDO connection
    $stmt = $userModel->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $authenticator = new \PHPGangsta_GoogleAuthenticator();
        if ($authenticator->verifyCode($user['twofa_secret'], $twofa_code, 2)) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
        } else {
            header('Location: login.php?error=' . urlencode('Invalid 2FA code'));
        }
    } else {
        header('Location: login.php?error=' . urlencode('Invalid credentials'));
    }
}