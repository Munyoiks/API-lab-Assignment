<?php
require 'vendor/autoload.php';
require 'User.php';
use PHPGangsta\GoogleAuthenticator;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $twofa_code = trim($_POST['2fa_code']);

    $userModel = new User();
    $stmt = $userModel->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $authenticator = new GoogleAuthenticator();
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