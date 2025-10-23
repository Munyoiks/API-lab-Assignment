<?php
// process.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors = [];
    if (empty($name)) $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (strlen($password) < 8) $errors[] = 'Password too short.';

    if (!empty($errors)) {
        // Redirect back with errors (use sessions or query params)
        header('Location: register.php?errors=' . urlencode(implode('<br>', $errors)));
        exit;
    }

    // Proceed to hash password and store (see below)
}