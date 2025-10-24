<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=' . urlencode('Please log in first.'));
    exit;
}

// Optional: load user info from database (if you want to show name/email)
require 'vendor/autoload.php';
require_once 'src/User.php';

use Group6\PhpOopLabs\User;

// Adjust this if your User class has a specific constructor
$userModel = new User();
$user = $userModel->getUserById($_SESSION['user_id']); // Create this function if not yet present
$username = $user['name'] ?? 'User';
$email = $user['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | PHP OOP 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <a href="logout.php" class="btn btn-outline-danger logout-btn">Logout</a>
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h2 class="text-primary mb-3">Welcome, <?= htmlspecialchars($username) ?> </h2>
                <?php if (!empty($email)): ?>
                    <p class="text-muted">You are logged in as <strong><?= htmlspecialchars($email) ?></strong></p>
                <?php endif; ?>
                <hr>
                <p class="lead">Your account is protected with <strong>2-Factor Authentication</strong>.</p>
                <a href="products.php" class="btn btn-success mt-3">Manage Products</a>
                <a href="users.php" class="btn btn-secondary mt-3">View Users</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
