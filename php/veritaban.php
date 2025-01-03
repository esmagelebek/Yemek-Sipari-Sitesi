<?php
$host = "127.0.0.1";
$dbname = "yemeksiparis"; // Veritabanı adı
$user = "root"; // Veritabanı kullanıcı adı
$password = "1234"; // Veritabanı şifresi

// Veritabanına bağlan
$conn = new mysqli($host, $user, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // SQL sorgusu
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Giriş başarılı! Sipariş sayfasına yönlendiriliyorsunuz...');</script>";
        echo "<script>window.location.href = 'siparis.html';</script>"; // Sipariş sayfasına yönlendirme
    } else {
        echo "<script>alert('Kullanıcı adı veya şifre yanlış.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
