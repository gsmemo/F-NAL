<?php
include 'csrf.php';
generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Davetli Sil</title>
</head>
<body>
    <form action="delete_guest.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="id">Davetli ID:</label>
        <input type="text" id="id" name="id" required><br><br>
        <input type="submit" value="Davetliyi Sil">
    </form>
</body>
</html>
