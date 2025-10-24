<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/src/User.php'; // Ensure correct path
require_once 'vendor/phpgangsta/googleauthenticator/PHPGangsta/GoogleAuthenticator.php';

use Group6\PhpOopLabs\User;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $twofa_code = trim($_POST['2fa_code']);

    try {
        // Create User instance (connects to php_lab_db)
        $userModel = new User();

        // Fetch user by email
        $stmt = $userModel->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Initialize Google Authenticator
            $authenticator = new \PHPGangsta_GoogleAuthenticator();

            // Verify 2FA code (2 = 2-minute window)
            if ($authenticator->verifyCode($user['twofa_secret'], $twofa_code, 2)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: dashboard.php');
                exit();
            } else {
                header('Location: login.php?error=' . urlencode('Invalid 2FA code.'));
                exit();
            }
        } else {
            header('Location: login.php?error=' . urlencode('Invalid email or password.'));
            exit();
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    } catch (Exception $e) {
        die("Unexpected error: " . $e->getMessage());
    }
}
?>
