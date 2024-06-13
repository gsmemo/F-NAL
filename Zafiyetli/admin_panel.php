<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 60%;
            text-align: center;
        }
        h2, h3 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        form label {
            margin: 5px 0;
        }
        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        td button {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        td button:hover {
            background-color: #c82333;
        }
    </style>
     <script>
        let timeout;

        function resetTimeout() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                window.location.href = 'index.html'; // Yönetici giriş sayfasına yönlendirme
            }, 200000); // 5 saniye 
        }

        document.addEventListener('mousemove', resetTimeout);
        document.addEventListener('keypress', resetTimeout);
        document.addEventListener('scroll', resetTimeout);
        document.addEventListener('click', resetTimeout);

        window.onload = resetTimeout;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteUser(id) {
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        location.reload(); // Refresh the page to update the table
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        }

        function deleteGuest(id) {
            $.ajax({
                url: 'delete_guest.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        location.reload(); // Refresh the page to update the table
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        }

        $(document).ready(function() {
            $('#addAssistantForm').on('submit', function(e) {
                e.preventDefault();

                const username = $('#username').val();
                const password = $('#password').val();

                $.ajax({
                    url: 'add_assistant.php',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message);
                            location.reload(); // Refresh the page to update the table
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function() {
                        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin Paneli</h2>
        <h3>Yardımcı Adminler</h3>
        <form id="addAssistantForm">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Yardımcı Admin Ekle">
        </form>
        <table>
            <tr>
                <th>Kullanıcı Adı</th>
                <th>İşlem</th>
            </tr>
            <?php
            // Veritabanı bağlantısı
            $database_file = "database.db";
            $db = new SQLite3($database_file);

            // Yardımcı adminleri çek
            $query = "SELECT * FROM users WHERE role='assistant_admin'";
            $result = $db->query($query);

            while ($row = $result->fetchArray()) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td><button onclick='deleteUser({$row['id']})'>Sil</button></td>";
                echo "</tr>";
            }

            // Veritabanı bağlantısını kapat
            $db->close();
            ?>
        </table>
        <h3>Davetliler</h3>
        <table>
            <tr>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Telefon</th>
                <th>İşlem</th>
            </tr>
            <?php
            // Veritabanı bağlantısı
            $database_file = "database.db";
            $db = new SQLite3($database_file);

            // Davetlileri çek
            $query = "SELECT * FROM guests";
            $result = $db->query($query);

            while ($row = $result->fetchArray()) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['surname']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td><button onclick='deleteGuest({$row['id']})'>Sil</button></td>";
                echo "</tr>";
            }

            // Veritabanı bağlantısını kapat
            $db->close();
            ?>
        </table>
    </div>
</body>
</html>
