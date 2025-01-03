<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yemeksiparis";

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Arama sorgusunu al
$query = $_GET['q'];
$sql = "SELECT name FROM tbl_yemek WHERE name LIKE '$query%'";

$result = $conn->query($sql);

$food = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $food[] = $row;
    }
}

echo json_encode($food);

$conn->close();
?>
