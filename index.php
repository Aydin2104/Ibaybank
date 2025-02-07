<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card = $_POST["card"];
    $password = $_POST["password"];

    $accounts = json_decode(file_get_contents("accounts.json"), true);

    foreach ($accounts as $account) {
        if ($account["card"] == $card && $account["password"] == $password) {
            if ($account["active"] == 0) {
                echo "Карта заблокирована.";
                exit;
            }
            $_SESSION["user"] = $account;
            header("Location: main.php");
            exit;
        }
    }
    echo "Неверные данные!";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <h1>Вход в банк</h1>
    <form method="post">
        Номер карты: <input type="text" name="card" required><br>
        Пароль: <input type="password" name="password" required><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>