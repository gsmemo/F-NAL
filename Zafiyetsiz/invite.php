<?php
// Veritabanı bağlantısı
include 'db.php';
$database_file = "database.db";
$db = new SQLite3($database_file);

// Hata ayıklama için hata mesajlarını göster
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Hata ayıklama için hata mesajlarını göster (güvenlik testi için, üretimde kapatılmalı)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Formdan gelen verileri al
// $name = $_POST['name'];
// $surname = $_POST['surname'];
// $phone = $_POST['phone'];

// xss acıgı önleme 
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$surname = htmlspecialchars($_POST['surname'], ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');


// SQL sorgusunu hazırlamak ve çalıştırmak
$stmt = $db->prepare("INSERT INTO guests (name, surname, phone) VALUES (:name, :surname, :phone)");
$stmt->bindValue(':name', $name, SQLITE3_TEXT);
$stmt->bindValue(':surname', $surname, SQLITE3_TEXT);
$stmt->bindValue(':phone', $phone, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    // Son eklenen ID'yi al
    $guest_id = $db->lastInsertRowID();
    // Başarılı mesajı göster
    echo "<script>alert('Kayıt başarıyla tamamlandı. Davetli ID\'niz: $guest_id');</script>";
    echo "Ad: " . htmlspecialchars($name) . "<br>";
    echo "Soyad: " . htmlspecialchars($surname) . "<br>";
    echo "Davetiye: Evet, davetlisiniz.";
    exit();
} else {
    echo "Bir hata oluştu. Lütfen tekrar deneyin.";
    echo "Hata: " . $db->lastErrorMsg(); // Hata mesajını göster
}

// Veritabanı bağlantısını kapat
$db->close();
?>
