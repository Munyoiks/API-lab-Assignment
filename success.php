<?php
session_start();

// Sanitize URL parameters
$qr = $_GET['qr'] ?? '';
$secret = $_GET['secret'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Success | PHP OOP 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .qr-img {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center">
                        <h2 class="text-success mb-4">🎉 Registration Successful!</h2>
                        <p class="text-muted">Scan this QR code using your Google Authenticator app:</p>

                        <?php if (!empty($qr)): ?>
                            <img src="<?= htmlspecialchars($qr) ?>" alt="QR Code" class="qr-img mb-3">
                        <?php else: ?>
                            <p class="text-danger">QR code not available.</p>
                        <?php endif; ?>

                        <?php if (!empty($secret)): ?>
                            <div class="mt-3">
                                <p class="mb-1"><strong>Your 2FA Secret:</strong></p>
                                <div class="input-group mb-3">
                                    <input type="text" id="secretKey" class="form-control text-center" value="<?= htmlspecialchars($secret) ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copySecret()">Copy</button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <a href="login.php" class="btn btn-primary mt-2">Proceed to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copySecret() {
            const secretInput = document.getElementById('secretKey');
            secretInput.select();
            document.execCommand('copy');
            alert('Secret copied to clipboard!');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
