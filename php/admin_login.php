<?php
session_start();
$host = "127.0.0.1";
$dbname = "yemeksiparis"; // Veritabanı adı
$user = "root"; // Veritabanı kullanıcı adı
$pass = "1234"; // Veritabanı şifresi

// Veritabanı bağlantısı
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

// Giriş işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Şifreleme MD5 ile yapılmış

    // Veritabanında kullanıcı doğrulama
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f3f3; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        .login-container h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: red; margin-bottom: 10px; text-align: center; }
        .form-group button { width: 100%; padding: 10px; background-color: #007BFF; border: none; color: #fff; border-radius: 4px; cursor: pointer; }
        .form-group button:hover { background-color: #0056b3; }
        .reset-link { text-align: center; margin-top: 10px; }
        .reset-link a { text-decoration: none; color: #007BFF; }
        .reset-link a:hover { color: #0056b3; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Giriş</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Giriş Yap</button>
            </div>
        </form>
        <div class="reset-link">
            <a href="reset_password.php">Şifremi Unuttum</a>
        </div>
    </div>
</body>
</html>
