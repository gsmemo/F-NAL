<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yardımcı Admin Paneli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            text-align: center;
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
        .message {
            font-size: 1.2em;
            margin: 20px 0;
            padding: 10px;
            border-radius: 8px;
            display: none;
        }
        .success {
            color: #4CAF50;
            background-color: #e8f5e9;
        }
        .error {
            color: #f44336;
            background-color: #ffebee;
        }
    </style>
    <script>
        let timeout;

        function resetTimeout() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                window.location.href = 'index.html'; // Yönetici giriş sayfasına yönlendirme
            }, 5000); // 5 saniye 
        }

        document.addEventListener('mousemove', resetTimeout);
        document.addEventListener('keypress', resetTimeout);
        document.addEventListener('scroll', resetTimeout);
        document.addEventListener('click', resetTimeout);

        window.onload = resetTimeout;
    </script>
    <script>
        function deleteGuest(id) {
            if (confirm('Bu davetliyi silmek istediğinizden emin misiniz?')) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_guest.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        var messageDiv = document.getElementById('message');
                        messageDiv.innerHTML = response.message;
                        messageDiv.className = 'message ' + response.status;
                        messageDiv.style.display = 'block';

                        if (response.status === 'success') {
                            document.getElementById('row-' + id).remove();
                        }
                    }
                };
                xhr.send("id=" + id);
            }
        }

        function updateGuestForm(id, name, surname, phone) {
            document.getElementById('updateId').value = id;
            document.getElementById('updateName').value = name;
            document.getElementById('updateSurname').value = surname;
            document.getElementById('updatePhone').value = phone;
            document.getElementById('updateForm').style.display = 'block';
        }

        function updateGuest() {
            var id = document.getElementById('updateId').value;
            var name = document.getElementById('updateName').value;
            var surname = document.getElementById('updateSurname').value;
            var phone = document.getElementById('updatePhone').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_guest.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    var messageDiv = document.getElementById('message');
                    messageDiv.innerHTML = response.message;
                    messageDiv.className = 'message ' + response.status;
                    messageDiv.style.display = 'block';

                    if (response.status === 'success') {
                        document.getElementById('row-' + id).innerHTML = "<td>" + name + "</td><td>" + surname + "</td><td>" + phone + "</td><td><button onclick='deleteGuest(" + id + ")'>Sil</button> <button onclick='updateGuestForm(" + id + ", \"" + name + "\", \"" + surname + "\", \"" + phone + "\")'>Güncelle</button></td>";
                    }

                    document.getElementById('updateForm').style.display = 'none';
                }
            };
            xhr.send("id=" + id + "&name=" + name + "&surname=" + surname + "&phone=" + phone);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Yardımcı Admin Paneli</h2>
        <h3>Davetliler</h3>
        <div id="message" class="message"></div>
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
                echo "<tr id='row-{$row['id']}'>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['surname']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td><button onclick='deleteGuest({$row['id']})'>Sil</button> <button onclick='updateGuestForm({$row['id']}, \"{$row['name']}\", \"{$row['surname']}\", \"{$row['phone']}\")'>Güncelle</button></td>";
                echo "</tr>";
            }

            // Veritabanı bağlantısını kapat
            $db->close();
            ?>
        </table>
        <div id="updateForm" style="display:none; margin-top: 20px;">
            <h3>Davetli Güncelle</h3>
            <input type="hidden" id="updateId">
            <div>
                <label for="updateName">Ad:</label>
                <input type="text" id="updateName">
            </div>
            <div>
                <label for="updateSurname">Soyad:</label>
                <input type="text" id="updateSurname">
            </div>
            <div>
                <label for="updatePhone">Telefon:</label>
                <input type="text" id="updatePhone">
            </div>
            <button onclick="updateGuest()">Güncelle</button>
        </div>
    </div>
</body>
</html>
