<?php
require __DIR__ . '/vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

// Generate 2FA secret
$authenticator = new GoogleAuthenticator();
$secret = $authenticator->generateSecret();
$qrCodeUrl = GoogleQrUrl::generate(
    $email,                  // user’s email or username
    $secret,                 // generated secret
    'PHP Lab App'            // your app or group name
);

// Store user and secret (example logic)

// Get POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

require_once __DIR__ . '/src/User.php';
$user = new User($name, $email, $password, $secret);
$userId = $user->register();

// Redirect to a page to display QR code
header('Location: success.php?secret=' . urlencode($secret) . '&qr=' . urlencode($qrCodeUrl));
exit;
