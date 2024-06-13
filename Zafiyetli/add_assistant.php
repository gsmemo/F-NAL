<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Veritabanı bağlantısı
    $database_file = "database.db";
    $db = new SQLite3($database_file);

    // Formdan gelen verileri al
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Yardımcı admin ekleme sorgusu
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'assistant_admin')";
    $result = $db->exec($query);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Yardımcı admin başarıyla eklendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bir hata oluştu, yardımcı admin eklenemedi.']);
    }

    // Veritabanı bağlantısını kapat
    $db->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gerekli alanlar belirtilmedi.']);
}
?>
