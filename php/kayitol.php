<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantısı
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "yemeksiparis";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

echo "Veritabanı bağlantısı başarılı!<br>";

// Formdan gelen veriler
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "POST isteği alındı!<br>";
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $telno = $_POST['telno'];

    echo "Kullanıcı Adı: $username<br>";
    echo "E-posta: $email<br>";
    echo "Telefon Numarası: $telno<br>";
    echo "Adres: $adres<br>";

    // Veritabanına ekleme
    $sql = "INSERT INTO tbl_kullanici (username, password, adres, email, telno) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $username, $password, $adres, $email, $telno);
        if ($stmt->execute()) {
            echo "Kayıt başarılı!<br>";
            header("Location: kullaniciGiris.html");
            exit();
        } else {
            echo "Hata: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Hata (prepare): " . $conn->error . "<br>";
    }
} else {
    echo "POST isteği alınamadı!<br>";
}

$conn->close();
?>
