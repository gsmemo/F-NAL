<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Veritabanı bağlantısı
    $database_file = "database.db";
    $db = new SQLite3($database_file);

    // POST verilerini al
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];

    // Davetliyi güncelle
    $query = "UPDATE guests SET name = :name, surname = :surname, phone = :phone WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':surname', $surname, SQLITE3_TEXT);
    $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Sonuç mesajını döndür
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Davetli başarıyla güncellendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Davetli güncellenirken bir hata oluştu.']);
    }

    // Veritabanı bağlantısını kapat
    $db->close();
}
?>
