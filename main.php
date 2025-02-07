<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Основная</title>
</head>
<body>
    <h1>Привет, <?= $user["name"] . " " . $user["surname"] ?></h1>
    <p>Баланс: <?= $user["balance"] ?> ₽</p>
    <a href="transfer.php">Перевод</a><br>
    <a href="logout.php">Выход</a>
</body>
</html>