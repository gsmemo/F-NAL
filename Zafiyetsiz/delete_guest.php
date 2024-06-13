<?php
// Veritabanı bağlantısı
$database_file = "database.db";
$db = new SQLite3($database_file);

// POST isteğinden gelen ID
// $id = $_POST['id'];


    // Formdan gelen ID'yi al ve özel karakterleri kaçır
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    
// Misafiri sil
$query = "DELETE FROM guests WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);

 // SQL sorgusunu hazırlamak ve çalıştırmak
 //$stmt = $db->prepare("DELETE FROM guests WHERE id = :id");
// $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
 //$result = $stmt->execute();
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Misafir başarıyla silindi."]);
} else {
    echo json_encode(["status" => "error", "message" => "Misafir silinirken bir hata oluştu."]);
}

// Veritabanı bağlantısını kapat
$db->close();
?>
