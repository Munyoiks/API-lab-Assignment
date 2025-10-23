<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registration Successful</h2>
        <p>Scan this QR code with Google Authenticator:</p>
        <img src="<?= htmlspecialchars($_GET['qr']) ?>" alt="QR Code">
        <p>Your 2FA secret: <?= htmlspecialchars($_GET['secret']) ?></p>
        <a href="login.php" class="btn btn-primary">Go to Login</a>
    </div>
</body>
</html>