<?php
$database_file = 'database.db';
if (!file_exists($database_file)) {
    $db = new SQLite3($database_file);

    // Kullanıcılar tablosunu oluşturma
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL,
        role TEXT NOT NULL
    )");

    // Davetliler tablosunu oluşturma
    $db->exec("CREATE TABLE IF NOT EXISTS guests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        surname TEXT NOT NULL,
        phone TEXT NOT NULL
    )");

    // Admin ve Yardımcı Admin kullanıcılarını ekleme
    $db->exec("INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin')");
    $db->exec("INSERT INTO users (username, password, role) VALUES ('assistant', 'assistant123', 'assistant_admin')");

    // Test davetlilerini ekleme
    $guests = [
        ['Ali', 'Veli', '555-1234567'],
        ['Ayşe', 'Yılmaz', '555-2345678'],
        ['Mehmet', 'Demir', '555-3456789'],
        ['Fatma', 'Kaya', '555-4567890'],
        ['Ahmet', 'Çelik', '555-5678901']
    ];

    foreach ($guests as $guest) {
        $db->exec("INSERT INTO guests (name, surname, phone) VALUES ('{$guest[0]}', '{$guest[1]}', '{$guest[2]}')");
    }

    $db->close();
}
?>
