<?php
require 'vendor/autoload.php';

use Group6\PhpOopLabs\User;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log received POST data
    error_log('POST Data: ' . print_r($_POST, true));

    // Retrieve and sanitize form inputs with fallback
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    // Check for errors
    if (!empty($errors)) {
        header('Location: register.php?errors=' . urlencode(implode('<br>', $errors)));
        exit;
    }

    //  Generate 2FA secret and QR code using Sonata library
   $authenticator = new \PHPGangsta_GoogleAuthenticator();
$secret = $authenticator->createSecret();

// The email or a fallback name
$accountName = $email ?: 'user_' . uniqid();

// Generate a QR code URL for the user
$qrCodeUrl = $authenticator->getQRCodeGoogleUrl(
    $accountName,
    $secret,
    'PhpOopLabs'
);


    // Store user in database
    try {
        $user = new User();
        $userId = $user->register($name, $email, $password, $secret);

        // Redirect to success page
        header('Location: success.php?secret=' . urlencode($secret) . '&qr=' . urlencode($qrCodeUrl));
        exit;
    } catch (Exception $e) {
        error_log('Registration error: ' . $e->getMessage());
        header('Location: register.php?errors=' . urlencode('Registration failed: ' . $e->getMessage()));
        exit;
    }
} else {
    header('Location: register.php');
    exit;
}
