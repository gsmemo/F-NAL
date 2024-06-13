<?php
// Veritabanı bağlantısı
include 'db.php';
$database_file = "database.db";
$db = new SQLite3($database_file);

// Formdan gelen davetli ID'sini al
$guest_id = $_POST['guest_id'];
//$guest_id = htmlspecialchars($_POST['guest_id'], ENT_QUOTES, 'UTF-8'); xss aciği önleme

// SQL injection açığı
$query = "SELECT * FROM guests WHERE id = '$guest_id'";
$result = $db->query($query);

// SQL aciğini önleme
//$stmt = $db->prepare("SELECT * FROM guests WHERE id = :guest_id");
//$stmt->bindValue(':guest_id', $guest_id, SQLITE3_INTEGER);
//$result = $stmt->execute();


// Tüm davetlileri listele
echo "<table>";
echo "<tr><th>Ad</th><th>Soyad</th><th>Telefon</th></tr>";

while ($row = $result->fetchArray()) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['surname'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Veritabanı bağlantısını kapat
$db->close();
?>
