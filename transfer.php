<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}
$user = $_SESSION["user"];
$accounts = json_decode(file_get_contents("accounts.json"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_card = $_POST["to_card"];
    $amount = $_POST["amount"];

    foreach ($accounts as &$account) {
        if ($account["card"] == $to_card) {
            $commission = $user["commission"] == 0 ? $amount * 0.1 : 0;
            $total = $amount + $commission;

            if ($user["balance"] >= $total) {
                $user["balance"] -= $total;
                $account["balance"] += $amount;

                foreach ($accounts as &$acc) {
                    if ($acc["card"] == $user["card"]) {
                        $acc = $user;
                    }
                }
                file_put_contents("accounts.json", json_encode($accounts, JSON_PRETTY_PRINT));
                echo "Перевод выполнен! Комиссия: $commission ₽";
            } else {
                echo "Недостаточно средств!";
            }
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Перевод</title>
</head>
<body>
    <h1>Перевод денег</h1>
    <form method="post">
        Куда (номер карты): <input type="text" name="to_card" required><br>
        Сумма: <input type="number" name="amount" required><br>
        <button type="submit">Перевести</button>
    </form>
    <a href="main.php">Назад</a>
</body>
</html>