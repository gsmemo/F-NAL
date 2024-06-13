<?php
if (isset($_POST['id'])) {
    // Veritabanı bağlantısı
    $database_file = "database.db";
    $db = new SQLite3($database_file);

    // Formdan gelen ID'yi al
    $id = $_POST['id'];

    // Kullanıcıyı silme sorgusu
    $query = "DELETE FROM users WHERE id='$id' AND role='assistant_admin'";
    $result = $db->exec($query);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Kullanıcı başarıyla silindi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bir hata oluştu, kullanıcı silinemedi.']);
    }

    // Veritabanı bağlantısını kapat
    $db->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Kullanıcı ID\'si belirtilmedi.']);
}
?>
