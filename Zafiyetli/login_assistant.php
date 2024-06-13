<?php
// Veritabanı bağlantısı
include 'db.php';
$database_file = "database.db";
$db = new SQLite3($database_file);

// Formdan gelen verileri al
$username = $_POST['username'];
$password = $_POST['password'];

// SQL injection açığı
$query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='assistant_admin'";
$result = $db->query($query);


// SQL injection açığı önlemek için hazırlıklı ifadeler kullan
//$query = "SELECT * FROM users WHERE username=:username AND password=:password AND role='assistant_admin'";
//$stmt = $db->prepare($query);
//$stmt->bindValue(':username', $username, SQLITE3_TEXT);
//$stmt->bindValue(':password', $password, SQLITE3_TEXT);
//$result = $stmt->execute();

// Kullanıcı varsa yönlendir
if ($result && $result->fetchArray()) {
    header("Location: assistant_panel.php");
    exit();
} else {
    echo "Hatalı kullanıcı adı veya şifre, lütfen tekrar deneyin.";
}

// Veritabanı bağlantısını kapat
$db->close();
?>
